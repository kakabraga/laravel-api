<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\AuditLogsRepositoryInterface;
use App\Domain\Customer\DTOs\CustomerDTO;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domain\Customer\Contexts\CustomerCreationContext;
use App\Domain\Customer\Contexts\CustomerUpdateContext;
use App\Domain\Customer\Rules\ValidateTypeDocumentRule;
use App\Domain\Customer\Rules\ValidateCustomerStatusRule;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
class CustomerService
{

    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private AuditLogsRepositoryInterface $auditLogsRepository,
        private Pipeline $pipeline,
    ) {

    }

    public function list(CustomerFilterDTO $filters): LengthAwarePaginator
    {
        return $this->customerRepository->paginateWithFilters($filters);
    }
    public function create(CustomerDTO $dados): Customer
    {
        $this->runCreatePipeline($dados);

        return DB::transaction(function () use ($dados) {

            $customer = $this->customerRepository->create(
                $dados->toArray()
            );
            $auditData = $this->buildAuditData(
                customer: $customer,
                action: 'created',
                auditChanges: [
                    'new_values' => $customer->toAuditArray(),
                    'old_values' => null
                ],
            );
            $this->auditLogsRepository->create($auditData);
            return $customer;
        });
    }

    public function delete(Customer $customer): void
    {
        $this->customerRepository->delete($customer);
    }

    public function update(Customer $customer, UpdateCustomerDTO $dto): Customer
    {
        $this->runUpdatePipeline($customer);
        return DB::transaction(function () use ($customer, $dto) {

            $old_values = $customer->toAuditArray();

            $this->customerRepository->update($customer, $dto->toArray());
            $customer->refresh();
            $new_values = $customer->toAuditArray();

            $diff = $this->getChangedValues($old_values, $new_values);

            $auditData = $this->buildAuditData(
                customer: $customer,
                action: 'updated',
                auditChanges: ['old_values' => $diff['old_values'], 'new_values' => $diff['new_values']]
            );

            $this->auditLogsRepository->create($auditData);
            return $customer;
        });
    }
    public function updateStatus(Customer $customer, UpdateCustomerDTO $updateCustomerDTO): Customer
    {
        $this->runUpdatePipeline($customer);
        return $this->customerRepository->updateStatus($customer, $updateCustomerDTO);
    }

    private function runCreatePipeline(
        CustomerDTO $dto,
    ): void {
        $this->pipeline
            ->send(new CustomerCreationContext($dto))
            ->through([
                ValidateTypeDocumentRule::class,
            ])
            ->thenReturn();

    }
    private function runUpdatePipeline(
        Customer $customer
    ): void {
        $this->pipeline
            ->send(new CustomerUpdateContext($customer))
            ->through([
                ValidateCustomerStatusRule::class,
            ])
            ->thenReturn();
    }

    private function buildAuditData(Customer $customer, string $action, array $auditChanges): array
    {
        return [
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => Customer::class,
            'auditable_id' => $customer->id,
            'old_values' => $auditChanges['old_values'],
            'new_values' => $auditChanges['new_values'],
            'ip' => request()->ip()
        ];
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
}