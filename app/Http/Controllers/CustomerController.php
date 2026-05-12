<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\CustomerService;
use App\Domain\Customer\DTOs\CustomerDTO;
use App\Domain\Customer\DTOs\UpdateCustomerDTO;
use App\Domain\Customer\DTOs\CustomerFilterDTO;
use App\Helpers\ApiResponse;
use App\Models\Customer;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CustomerService $customerService)
    {
        $dto = CustomerFilterDTO::fromArray($request->all());
        return ApiResponse::success((
            CustomerResource::collection(
                $customerService->list($dto)
            )
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request, CustomerService $customerService)
    {
        $dto = CustomerDTO::fromArray($request->validated());

        return ApiResponse::success(
            new CustomerResource(
                $customerService->create($dto)
            ),
            "Customer created successfully.",
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return ApiResponse::success(
            new CustomerResource($customer)
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, CustomerService $customerService, Customer $customer)
    {
        $dto = UpdateCustomerDTO::fromArray($request->validated());
        return ApiResponse::success(
            new CustomerResource(
                $customerService->update($customer, $dto)
            ),
            "Customer updated successfully.",
        );
    }

    public function updateStatus(UpdateCustomerRequest $request, Customer $customer, CustomerService $customerService)
    {
        $dto = UpdateCustomerDTO::fromArray($request->validated());
        return ApiResponse::success(
            new CustomerResource(
                $customerService->updateStatus($customer, $dto)
            ),
            "Customer updated successfully.",
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, CustomerService $customerService)
    {
        $customerService->delete($customer);
        return response()->noContent();
    }
}
