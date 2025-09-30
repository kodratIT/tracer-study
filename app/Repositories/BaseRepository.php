<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;
    protected Builder $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->resetQuery();
    }

    /**
     * Get all records
     */
    public function all(): Collection
    {
        $result = $this->query->get();
        $this->resetQuery();
        return $result;
    }

    /**
     * Get records with pagination
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        $result = $this->query->paginate($perPage);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find record by ID
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find record by ID or fail
     */
    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Find records by criteria
     */
    public function findBy(array $criteria): Collection
    {
        $query = $this->model->newQuery();
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }
        return $query->get();
    }

    /**
     * Find single record by criteria
     */
    public function findOneBy(array $criteria): ?Model
    {
        $query = $this->model->newQuery();
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }
        return $query->first();
    }

    /**
     * Create new record
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);
        return $record->delete();
    }

    /**
     * Get records with relations
     */
    public function with(array $relations): self
    {
        $this->query = $this->query->with($relations);
        return $this;
    }

    /**
     * Apply where condition
     */
    public function where(string $column, $operator, $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        $this->query = $this->query->where($column, $operator, $value);
        return $this;
    }

    /**
     * Order by column
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        $this->query = $this->query->orderBy($column, $direction);
        return $this;
    }

    /**
     * Reset query builder
     */
    protected function resetQuery(): void
    {
        $this->query = $this->model->newQuery();
    }
}
