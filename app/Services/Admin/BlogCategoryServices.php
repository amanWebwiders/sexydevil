<?php

namespace App\Services\Admin;

use App\Models\BlogCategory;
use App\Repository\BlogCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogCategoryServices
{
    protected $blogCategoryRepository;

    public function __construct(BlogCategoryRepositoryInterface $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function list(array $filters): LengthAwarePaginator
    {
        return $this->blogCategoryRepository->paginate($filters);
    }

    public function find(int $id): ?BlogCategory
    {
        return $this->blogCategoryRepository->findById($id);
    }

    public function create(array $data): BlogCategory
    {
        return $this->blogCategoryRepository->create($this->payload($data));
    }

    public function update(int $id, array $data): bool
    {
        return $this->blogCategoryRepository->update($id, $this->payload($data));
    }

    public function delete(int $id): bool
    {
        return $this->blogCategoryRepository->delete($id);
    }

    public function toggleStatus(int $id): BlogCategory
    {
        return $this->blogCategoryRepository->toggleStatus($id);
    }

    public function stats(): array
    {
        return [
            'total' => $this->blogCategoryRepository->count(),
            'active' => $this->blogCategoryRepository->countActive(),
        ];
    }

    /**
     * Map validated form input to table columns.
     */
    private function payload(array $data): array
    {
        return [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'status' => (int) $data['status'],
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'robots_index' => $data['robots_index'],
            'robots_follow' => $data['robots_follow'],
        ];
    }
}
