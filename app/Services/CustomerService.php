<?php

namespace App\Services;

use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Domain\Customer\DTOs\CustomerDTO;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use App\Models\Customer;
class CustomerService
{

    public function __construct(
        private CustomerRepositoryInterface $customerRepository
    ) {

    }

    public function list(CustomerFilterDTO $filters)
    {
        return $this->customerRepository->paginateWithFilters(
            $filters,
            $filters->perPage
        );
    }
    public function create(CustomerDTO $dados): Customer
    {

        $customer = $this->customerRepository->create([
            'name' => $dados->name,
            'email' => $dados->email,
            'document' => $dados->document,
            'type' => $dados->type,
            'phone' => $dados->phone,
            'address' => $dados->address,
            'city' => $dados->city,
            'state' => $dados->state,
            'zip_code' => $dados->zip_code
        ]);

        return $customer;
    }

    public function delete(Customer $customer)
    {
        return $this->customerRepository->delete($customer);
    }

    public function update(Customer $customer, UpdateCustomerDTO $dto): Customer
    {
        return $this->customerRepository->update($customer, $dto->toArray());
    }

    private function allowedSorts(): array
    {
        return [
            'created_at',
            'name',
            'city',
            'state',
            'type',
            'updated_at'
        ];
    }
}