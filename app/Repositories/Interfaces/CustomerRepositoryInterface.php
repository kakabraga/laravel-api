<?php

namespace App\Repositories\Interfaces;

use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Models\Customer;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface CustomerRepositoryInterface
{

    public function create(array $data): Customer;
    public function delete(Customer $customer): void;
    public function update(Customer $customer, array $data) : Customer;
    public function updateStatus(Customer $customer, UpdateCustomerDTO $data): Customer;
   public function paginateWithFilters(CustomerFilterDTO $filters): LengthAwarePaginator;

}