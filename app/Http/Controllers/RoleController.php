<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Role;
use App\Helpers\PaginationHelper;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $roles = PaginationHelper::paginateWithFilters(Role::query(), $request, ['name']);

            $response = [
                'code' => 200,
                'status' => 'success',
            ];

            if (isset($roles['pagination'])) {
                $response['pagination'] = $roles['pagination'];
            }

            $response['data'] = $roles['data'];

            return response()->json($response, 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'status' => 'required|in:1,0',
            ]);

            $role = Role::create($data);

            return response()->json([
                'code' => 201,
                'status' => 'success',
                'data' => $role
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|exists:roles,id',
                'name' => 'required|string',
                'status' => 'required|in:1,0',
            ]);

            $role = Role::find($data['id']);
            $role->update($data);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $role
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            $role->delete();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Role deleted successfully'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
