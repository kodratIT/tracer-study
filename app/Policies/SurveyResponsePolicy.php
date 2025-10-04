<?php

namespace App\Policies;

use App\Models\User;
use Modules\Survey\Models\SurveyResponse;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_survey_response');
    }

    public function view(User $user, SurveyResponse $model): bool
    {
        return $user->can('view_survey_response');
    }

    public function create(User $user): bool
    {
        return $user->can('create_survey_response');
    }

    public function update(User $user, SurveyResponse $model): bool
    {
        return $user->can('update_survey_response');
    }

    public function delete(User $user, SurveyResponse $model): bool
    {
        return $user->can('delete_survey_response');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_survey_response');
    }

    public function forceDelete(User $user, SurveyResponse $model): bool
    {
        return $user->can('force_delete_survey_response');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_survey_response');
    }

    public function restore(User $user, SurveyResponse $model): bool
    {
        return $user->can('restore_survey_response');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_survey_response');
    }

    public function replicate(User $user, SurveyResponse $model): bool
    {
        return $user->can('replicate_survey_response');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_survey_response');
    }
}
