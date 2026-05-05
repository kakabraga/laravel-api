<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function create(array $dados): Customer
    {
        return Customer::create($dados);
    }
    public function delete(Customer $customer): bool
    {
        return $customer->delete();
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function paginateWithFilters(CustomerFilterDTO $filters, int $perPage): LengthAwarePaginator
    {
        return Customer::orderBy($filters->sort, $filters->order)
            ->paginate($perPage);
    }
}