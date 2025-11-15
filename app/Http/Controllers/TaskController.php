<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Task::query();

        // filtering
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($priority = $request->query('priority')) {
            $query->where('priority', $priority);
        }
        if ($search = $request->query('q')) {
            // text search on title/description (Mongo $text) if index exists, else fallback regex
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($dueFrom = $request->query('dueFrom')) {
            $query->where('dueDate', '>=', Carbon::parse($dueFrom)->startOfDay());
        }
        if ($dueTo = $request->query('dueTo')) {
            $query->where('dueDate', '<=', Carbon::parse($dueTo)->endOfDay());
        }

        // sort (default newest)
        $sort = $request->query('sort', '-created_at');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $field = ltrim($sort, '+-');
        $query->where('ownerId', $request->header('X-Owner-Id'));
        $query->orderBy($field, $direction);

        // pagination (page, per_page)
        $perPage = min(max((int)$request->query('per_page', 10), 1), 100);
        $page = max((int)$request->query('page', 1), 1);
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'sort' => $sort
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $task = Task::create(array_merge($request->validated(), [
            'ownerId' => $request->header('X-Owner-Id') ?? 'demo-user'
        ]));
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->fill($request->validated());
        $task->save();
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
