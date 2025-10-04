<?php

namespace App\Policies;

use App\Models\User;
use Modules\Survey\Models\TracerStudySession;
use Illuminate\Auth\Access\HandlesAuthorization;

class TracerStudySessionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tracer_study_session');
    }

    public function view(User $user, TracerStudySession $model): bool
    {
        return $user->can('view_tracer_study_session');
    }

    public function create(User $user): bool
    {
        return $user->can('create_tracer_study_session');
    }

    public function update(User $user, TracerStudySession $model): bool
    {
        return $user->can('update_tracer_study_session');
    }

    public function delete(User $user, TracerStudySession $model): bool
    {
        return $user->can('delete_tracer_study_session');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_tracer_study_session');
    }

    public function forceDelete(User $user, TracerStudySession $model): bool
    {
        return $user->can('force_delete_tracer_study_session');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_tracer_study_session');
    }

    public function restore(User $user, TracerStudySession $model): bool
    {
        return $user->can('restore_tracer_study_session');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_tracer_study_session');
    }

    public function replicate(User $user, TracerStudySession $model): bool
    {
        return $user->can('replicate_tracer_study_session');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_tracer_study_session');
    }
}
