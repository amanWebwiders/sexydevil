<?php

namespace App\Repository;

use App\Models\BlogCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BlogCategoryRepositoryInterface
{
    /**
     * Paginated list filtered by optional "search" and "status" keys.
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?BlogCategory;

    public function create(array $data): BlogCategory;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function toggleStatus(int $id): BlogCategory;

    public function count(): int;

    public function countActive(): int;
}
