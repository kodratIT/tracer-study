<?php

namespace App\Services;

use App\Contracts\RepositoryInterface;
use App\Contracts\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseService implements ServiceInterface
{
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     */
    public function getAll(): Collection
    {
        try {
            return $this->repository->all();
        } catch (\Exception $e) {
            Log::error('Error fetching all records: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get paginated records
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->repository->paginate($perPage);
        } catch (\Exception $e) {
            Log::error('Error fetching paginated records: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Find record by ID
     */
    public function getById(int $id): ?Model
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            Log::error("Error fetching record with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create new record
     */
    public function store(array $data): Model
    {
        DB::beginTransaction();
        try {
            $data = $this->prepareDataForCreate($data);
            $record = $this->repository->create($data);
            
            $this->afterCreate($record, $data);
            
            DB::commit();
            Log::info('Record created successfully', ['id' => $record->id]);
            
            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating record: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update existing record
     */
    public function update(int $id, array $data): Model
    {
        DB::beginTransaction();
        try {
            $data = $this->prepareDataForUpdate($data);
            $record = $this->repository->update($id, $data);
            
            $this->afterUpdate($record, $data);
            
            DB::commit();
            Log::info('Record updated successfully', ['id' => $id]);
            
            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating record with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete record
     */
    public function destroy(int $id): bool
    {
        DB::beginTransaction();
        try {
            $record = $this->repository->findOrFail($id);
            
            $this->beforeDelete($record);
            
            $result = $this->repository->delete($id);
            
            $this->afterDelete($record);
            
            DB::commit();
            Log::info('Record deleted successfully', ['id' => $id]);
            
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting record with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Prepare data before create
     */
    protected function prepareDataForCreate(array $data): array
    {
        return $data;
    }

    /**
     * Prepare data before update
     */
    protected function prepareDataForUpdate(array $data): array
    {
        return $data;
    }

    /**
     * Hook after create
     */
    protected function afterCreate(Model $record, array $data): void
    {
        // Override in child classes if needed
    }

    /**
     * Hook after update
     */
    protected function afterUpdate(Model $record, array $data): void
    {
        // Override in child classes if needed
    }

    /**
     * Hook before delete
     */
    protected function beforeDelete(Model $record): void
    {
        // Override in child classes if needed
    }

    /**
     * Hook after delete
     */
    protected function afterDelete(Model $record): void
    {
        // Override in child classes if needed
    }
}
