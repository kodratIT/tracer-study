<?php

namespace App\Policies;

use App\Models\User;
use Modules\Employment\Models\Employer;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_employer');
    }

    public function view(User $user, Employer $model): bool
    {
        return $user->can('view_employer');
    }

    public function create(User $user): bool
    {
        return $user->can('create_employer');
    }

    public function update(User $user, Employer $model): bool
    {
        return $user->can('update_employer');
    }

    public function delete(User $user, Employer $model): bool
    {
        return $user->can('delete_employer');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_employer');
    }

    public function forceDelete(User $user, Employer $model): bool
    {
        return $user->can('force_delete_employer');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_employer');
    }

    public function restore(User $user, Employer $model): bool
    {
        return $user->can('restore_employer');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_employer');
    }

    public function replicate(User $user, Employer $model): bool
    {
        return $user->can('replicate_employer');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_employer');
    }
}
