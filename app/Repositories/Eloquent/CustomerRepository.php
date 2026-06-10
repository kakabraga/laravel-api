<?php
namespace App\Repositories\Eloquent;

use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use App\Models\Customer;
use App\Enums\CustomerStatus;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function create(array $dados): Customer
    {
        return Customer::create($dados);
    }
    public function delete(Customer $customer): void
    {
        $customer->delete();
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function paginateWithFilters(CustomerFilterDTO $filters): LengthAwarePaginator
    {
        return Customer::orderBy($filters->sort, $filters->order)
            ->paginate($filters->perPage);
    }

    public function updateStatus(Customer $customer, UpdateCustomerDTO $data): Customer
    {
        $customer->status = $data->status;
        $customer->save();

        return $customer;
    }

}