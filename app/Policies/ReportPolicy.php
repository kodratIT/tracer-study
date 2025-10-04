<?php

namespace App\Policies;

use App\Models\User;
use Modules\Reports\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_report');
    }

    public function view(User $user, Report $model): bool
    {
        return $user->can('view_report');
    }

    public function create(User $user): bool
    {
        return $user->can('create_report');
    }

    public function update(User $user, Report $model): bool
    {
        return $user->can('update_report');
    }

    public function delete(User $user, Report $model): bool
    {
        return $user->can('delete_report');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_report');
    }

    public function forceDelete(User $user, Report $model): bool
    {
        return $user->can('force_delete_report');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_report');
    }

    public function restore(User $user, Report $model): bool
    {
        return $user->can('restore_report');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_report');
    }

    public function replicate(User $user, Report $model): bool
    {
        return $user->can('replicate_report');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_report');
    }
}
