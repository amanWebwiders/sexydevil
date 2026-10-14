<?php

namespace App\Repository;

use App\Models\Blog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BlogRepositoryInterface
{
    /**
     * Paginated list filtered by optional "search", "status", "category", "country_id",
     * "state_id", "city_id", "date_from" and "date_to" keys.
     */
    public function paginate(array $filters = [], int $perPage = 12): LengthAwarePaginator;

    public function findById(int $id): ?Blog;

    public function create(array $data): Blog;

    public function update(Blog $blog, array $data): bool;

    public function delete(Blog $blog): bool;

    public function slugExists(string $slug, ?int $ignoreId = null): bool;

    /**
     * @return array<string,int> effective status => count
     */
    public function statusCounts(): array;
}
