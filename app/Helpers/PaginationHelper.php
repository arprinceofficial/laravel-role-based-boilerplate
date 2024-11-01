<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PaginationHelper
{
    public static function paginateWithFilters(Builder $query, Request $request, array $searchableColumns = [])
    {
        // Get request parameters
        $page = $request->input('page');
        $limit = $request->input('limit');
        $search = $request->input('search');
        $status = $request->input('status');

        // If page, limit, and search are empty, retrieve all records
        if ($page === null && $limit === null && empty($search)) {
            // Optionally filter by status if it has a value
            if ($status !== null) {
                $query->where('status', $status);
            }
            $data = $query->get();
            return [
                'data' => $data,
            ];
        }

        // Apply status filter if provided
        if ($status !== null) {
            $query->where('status', $status);
        }

        // Apply search filter if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        // Paginate data if pagination is requested
        $result = $query->paginate($limit ?? 10, ['*'], 'page', $page ?? 1);

        return [
            'pagination' => [
                'from' => $result->firstItem(),
                'to' => $result->lastItem(),
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
            ],
            'data' => $result->items(),
        ];
    }
}
