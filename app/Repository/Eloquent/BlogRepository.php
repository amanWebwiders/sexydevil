<?php

namespace App\Repository\Eloquent;

use App\Models\Blog;
use App\Repository\BlogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogRepository implements BlogRepositoryInterface
{
    protected $model;

    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function paginate(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['categories:id,name', 'author:id,name', 'country:id,name', 'state:id,name', 'city:id,name']);

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status']) && array_key_exists($filters['status'], Blog::STATUSES)) {
            $query->effectiveStatus($filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->whereHas('categories', fn ($q) => $q->where('blog_categories.id', $filters['category']));
        }

        foreach (['country_id', 'state_id', 'city_id'] as $column) {
            if (!empty($filters[$column])) {
                $query->where($column, $filters[$column]);
            }
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('published_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('published_at', '<=', $filters['date_to']);
        }

        return $query->orderByDesc('updated_at')->orderByDesc('id')->paginate($perPage);
    }

    public function findById(int $id): ?Blog
    {
        return $this->model->with('categories:id,name')->find($id);
    }

    public function create(array $data): Blog
    {
        return $this->model->create($data);
    }

    public function update(Blog $blog, array $data): bool
    {
        return $blog->update($data);
    }

    public function delete(Blog $blog): bool
    {
        return (bool) $blog->delete();
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return $this->model->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }

    public function statusCounts(): array
    {
        $counts = ['all' => $this->model->count()];

        foreach (array_keys(Blog::STATUSES) as $status) {
            $counts[$status] = $this->model->newQuery()->effectiveStatus($status)->count();
        }

        return $counts;
    }
}
