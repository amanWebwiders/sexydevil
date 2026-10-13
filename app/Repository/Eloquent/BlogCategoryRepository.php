<?php

namespace App\Repository\Eloquent;

use App\Models\BlogCategory;
use App\Repository\BlogCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogCategoryRepository implements BlogCategoryRepositoryInterface
{
    protected $model;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?BlogCategory
    {
        return $this->model->find($id);
    }

    public function create(array $data): BlogCategory
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->findOrFail($id)->delete();
    }

    public function toggleStatus(int $id): BlogCategory
    {
        $category = $this->model->findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();

        return $category;
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countActive(): int
    {
        return $this->model->active()->count();
    }
}
