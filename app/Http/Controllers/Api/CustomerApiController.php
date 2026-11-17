<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    /**
     * Add a new customer
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCustomer(Request $request)
    {
        try {
            // Validate input with strict rules
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'min:2'
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'min:7',
                    'regex:/^[\d\s\+\-\(\)]+$/' // Digits and phone formatting characters
                ],
                'address' => [
                    'required',
                    'string',
                    'max:500',
                    'min:5'
                ]
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get validated data (safe from SQL injection)
            $validated = $validator->validated();

            // Check if customer with this phone exists, if yes update, if no create
            $customer = Customer::updateOrCreate(
                ['phone' => trim($validated['phone'])],
                [
                    'name' => trim($validated['name']),
                    'address' => trim($validated['address'])
                ]
            );

            $isNewCustomer = $customer->wasRecentlyCreated;

            return response()->json([
                'success' => true,
                'message' => $isNewCustomer ? 'Customer added successfully' : 'Customer updated successfully',
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'created_at' => $customer->created_at,
                    'updated_at' => $customer->updated_at,
                    'is_new' => $isNewCustomer
                ]
            ], $isNewCustomer ? 201 : 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
