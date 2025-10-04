<?php

namespace App\Policies;

use App\Models\User;
use Modules\Survey\Models\SurveyQuestion;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyQuestionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_survey_question');
    }

    public function view(User $user, SurveyQuestion $model): bool
    {
        return $user->can('view_survey_question');
    }

    public function create(User $user): bool
    {
        return $user->can('create_survey_question');
    }

    public function update(User $user, SurveyQuestion $model): bool
    {
        return $user->can('update_survey_question');
    }

    public function delete(User $user, SurveyQuestion $model): bool
    {
        return $user->can('delete_survey_question');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_survey_question');
    }

    public function forceDelete(User $user, SurveyQuestion $model): bool
    {
        return $user->can('force_delete_survey_question');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_survey_question');
    }

    public function restore(User $user, SurveyQuestion $model): bool
    {
        return $user->can('restore_survey_question');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_survey_question');
    }

    public function replicate(User $user, SurveyQuestion $model): bool
    {
        return $user->can('replicate_survey_question');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_survey_question');
    }
}
