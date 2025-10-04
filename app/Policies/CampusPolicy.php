<?php

namespace App\Policies;

use App\Models\User;
use Modules\Education\Models\Campus;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampusPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_campus');
    }

    public function view(User $user, Campus $model): bool
    {
        return $user->can('view_campus');
    }

    public function create(User $user): bool
    {
        return $user->can('create_campus');
    }

    public function update(User $user, Campus $model): bool
    {
        return $user->can('update_campus');
    }

    public function delete(User $user, Campus $model): bool
    {
        return $user->can('delete_campus');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_campus');
    }

    public function forceDelete(User $user, Campus $model): bool
    {
        return $user->can('force_delete_campus');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_campus');
    }

    public function restore(User $user, Campus $model): bool
    {
        return $user->can('restore_campus');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_campus');
    }

    public function replicate(User $user, Campus $model): bool
    {
        return $user->can('replicate_campus');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_campus');
    }
}
