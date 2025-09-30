<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Get all records
     */
    public function all(): Collection;

    /**
     * Get records with pagination
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find record by ID
     */
    public function find(int $id): ?Model;

    /**
     * Find record by ID or fail
     */
    public function findOrFail(int $id): Model;

    /**
     * Find records by criteria
     */
    public function findBy(array $criteria): Collection;

    /**
     * Find single record by criteria
     */
    public function findOneBy(array $criteria): ?Model;

    /**
     * Create new record
     */
    public function create(array $data): Model;

    /**
     * Update record
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete record
     */
    public function delete(int $id): bool;

    /**
     * Get records with relations
     */
    public function with(array $relations): self;

    /**
     * Apply where condition
     */
    public function where(string $column, $operator, $value = null): self;

    /**
     * Order by column
     */
    public function orderBy(string $column, string $direction = 'asc'): self;
}
