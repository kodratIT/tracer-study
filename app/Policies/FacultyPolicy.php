<?php

namespace App\Policies;

use App\Models\User;
use Modules\Education\Models\Faculty;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_faculty');
    }

    public function view(User $user, Faculty $model): bool
    {
        return $user->can('view_faculty');
    }

    public function create(User $user): bool
    {
        return $user->can('create_faculty');
    }

    public function update(User $user, Faculty $model): bool
    {
        return $user->can('update_faculty');
    }

    public function delete(User $user, Faculty $model): bool
    {
        return $user->can('delete_faculty');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_faculty');
    }

    public function forceDelete(User $user, Faculty $model): bool
    {
        return $user->can('force_delete_faculty');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_faculty');
    }

    public function restore(User $user, Faculty $model): bool
    {
        return $user->can('restore_faculty');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_faculty');
    }

    public function replicate(User $user, Faculty $model): bool
    {
        return $user->can('replicate_faculty');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_faculty');
    }
}
