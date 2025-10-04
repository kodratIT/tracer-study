<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \Modules\Alumni\Models\Alumni::class => \App\Policies\AlumniPolicy::class,
        \Modules\Education\Models\Campus::class => \App\Policies\CampusPolicy::class,
        \Modules\Education\Models\Department::class => \App\Policies\DepartmentPolicy::class,
        \Modules\Education\Models\Faculty::class => \App\Policies\FacultyPolicy::class,
        \Modules\Education\Models\Program::class => \App\Policies\ProgramPolicy::class,
        \Modules\Employment\Models\Employer::class => \App\Policies\EmployerPolicy::class,
        \Modules\Employment\Models\EmploymentHistory::class => \App\Policies\EmploymentHistoryPolicy::class,
        \Modules\Survey\Models\SurveyQuestion::class => \App\Policies\SurveyQuestionPolicy::class,
        \Modules\Survey\Models\SurveyResponse::class => \App\Policies\SurveyResponsePolicy::class,
        \Modules\Survey\Models\TracerStudySession::class => \App\Policies\TracerStudySessionPolicy::class,
        \Modules\Reports\Models\Report::class => \App\Policies\ReportPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Super Admin has access to everything
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
