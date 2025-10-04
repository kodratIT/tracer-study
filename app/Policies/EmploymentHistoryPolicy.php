<?php

namespace App\Policies;

use App\Models\User;
use Modules\Employment\Models\EmploymentHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmploymentHistoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_employment_history');
    }

    public function view(User $user, EmploymentHistory $model): bool
    {
        return $user->can('view_employment_history');
    }

    public function create(User $user): bool
    {
        return $user->can('create_employment_history');
    }

    public function update(User $user, EmploymentHistory $model): bool
    {
        return $user->can('update_employment_history');
    }

    public function delete(User $user, EmploymentHistory $model): bool
    {
        return $user->can('delete_employment_history');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_employment_history');
    }

    public function forceDelete(User $user, EmploymentHistory $model): bool
    {
        return $user->can('force_delete_employment_history');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_employment_history');
    }

    public function restore(User $user, EmploymentHistory $model): bool
    {
        return $user->can('restore_employment_history');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_employment_history');
    }

    public function replicate(User $user, EmploymentHistory $model): bool
    {
        return $user->can('replicate_employment_history');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_employment_history');
    }
}
