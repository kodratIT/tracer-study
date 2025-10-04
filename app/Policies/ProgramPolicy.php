<?php

namespace App\Policies;

use App\Models\User;
use Modules\Education\Models\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_program');
    }

    public function view(User $user, Program $model): bool
    {
        return $user->can('view_program');
    }

    public function create(User $user): bool
    {
        return $user->can('create_program');
    }

    public function update(User $user, Program $model): bool
    {
        return $user->can('update_program');
    }

    public function delete(User $user, Program $model): bool
    {
        return $user->can('delete_program');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_program');
    }

    public function forceDelete(User $user, Program $model): bool
    {
        return $user->can('force_delete_program');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_program');
    }

    public function restore(User $user, Program $model): bool
    {
        return $user->can('restore_program');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_program');
    }

    public function replicate(User $user, Program $model): bool
    {
        return $user->can('replicate_program');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_program');
    }
}
