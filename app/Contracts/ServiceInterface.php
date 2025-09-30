<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceInterface
{
    /**
     * Get all records
     */
    public function getAll(): Collection;

    /**
     * Get paginated records
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find record by ID
     */
    public function getById(int $id): ?Model;

    /**
     * Create new record
     */
    public function store(array $data): Model;

    /**
     * Update existing record
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete record
     */
    public function destroy(int $id): bool;
}
