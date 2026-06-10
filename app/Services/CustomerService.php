<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Domain\Customer\DTOs\CustomerDTO;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domain\Customer\Contexts\CustomerCreationContext;
use App\Domain\Customer\Contexts\CustomerUpdateContext;
use App\Domain\Customer\Rules\ValidateTypeDocumentRule;
use App\Domain\Customer\Rules\ValidateCustomerStatusRule;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Jobs\SaveAuditLogJob;

class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private Pipeline $pipeline,
    ) {}

    public function list(CustomerFilterDTO $filters): LengthAwarePaginator
    {
        return $this->customerRepository->paginateWithFilters($filters);
    }

    public function create(CustomerDTO $dados): Customer
    {
        $this->runCreatePipeline($dados);

        $customer = DB::transaction(function () use ($dados) {
            return $this->customerRepository->create($dados->toArray());
        });

        $this->dispatchAuditLog($customer, 'created');

        return $customer;
    }

    public function delete(Customer $customer): void
    {
        $this->customerRepository->delete($customer);
    }

    public function update(Customer $customer, UpdateCustomerDTO $dto): Customer
    {
        $this->runUpdatePipeline($customer);

        $oldValues = $customer->toAuditArray();

        DB::transaction(function () use ($customer, $dto) {
            $this->customerRepository->update($customer, $dto->toArray());
            $customer->refresh();
        });

        $diff = $this->getChangedValues($oldValues, $customer->toAuditArray());

        $this->dispatchAuditLog($customer, 'updated', $diff['old_values'] ?? null);

        return $customer;
    }

    public function updateStatus(Customer $customer, UpdateCustomerDTO $updateCustomerDTO): Customer
    {
        $this->runUpdatePipeline($customer);
        return $this->customerRepository->updateStatus($customer, $updateCustomerDTO);
    }

    private function runCreatePipeline(CustomerDTO $dto): void
    {
        $this->pipeline
            ->send(new CustomerCreationContext($dto))
            ->through([ValidateTypeDocumentRule::class])
            ->thenReturn();
    }

    private function runUpdatePipeline(Customer $customer): void
    {
        $this->pipeline
            ->send(new CustomerUpdateContext($customer))
            ->through([ValidateCustomerStatusRule::class])
            ->thenReturn();
    }

    private function getChangedValues(array $old_values, array $new_values): array
    {
        $retorno = [];
        foreach ($old_values as $key => $oldValue) {
            $newValue = $new_values[$key] ?? null;
            if ($oldValue !== $newValue) {
                $retorno['old_values'][$key] = $oldValue;
                $retorno['new_values'][$key] = $newValue;
            }
        }
        return $retorno;
    }

    private function dispatchAuditLog(Customer $customer, string $action, ?array $oldValues = null): void
    {
        SaveAuditLogJob::dispatch(
            auditableType: Customer::class,
            auditableId:   $customer->id,
            action:        $action,
            userId:        auth()->id(),
            ip:            request()->ip(),
            newValues:     $customer->toAuditArray(),
            oldValues:     $oldValues,
        );
    }
}