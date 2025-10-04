<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateResourcePolicies extends Command
{
    protected $signature = 'shield:generate-policies';
    protected $description = 'Generate policies for all resources based on permissions';

    protected $resources = [
        'Alumni' => 'Modules\Alumni\Models\Alumni',
        'Campus' => 'Modules\Education\Models\Campus',
        'Department' => 'Modules\Education\Models\Department',
        'Faculty' => 'Modules\Education\Models\Faculty',
        'Program' => 'Modules\Education\Models\Program',
        'Employer' => 'Modules\Employment\Models\Employer',
        'EmploymentHistory' => 'Modules\Employment\Models\EmploymentHistory',
        'SurveyQuestion' => 'Modules\Survey\Models\SurveyQuestion',
        'SurveyResponse' => 'Modules\Survey\Models\SurveyResponse',
        'TracerStudySession' => 'Modules\Survey\Models\TracerStudySession',
        'Report' => 'Modules\Reports\Models\Report',
        'User' => 'App\Models\User',
    ];

    public function handle()
    {
        $policyPath = app_path('Policies');
        
        if (!File::exists($policyPath)) {
            File::makeDirectory($policyPath, 0755, true);
        }

        foreach ($this->resources as $resourceName => $modelClass) {
            $this->generatePolicy($resourceName, $modelClass, $policyPath);
        }

        $this->info('All policies generated successfully!');
        $this->info('Run: php artisan optimize:clear');
    }

    protected function generatePolicy($resourceName, $modelClass, $policyPath)
    {
        $policyName = "{$resourceName}Policy";
        $policyFile = "{$policyPath}/{$policyName}.php";
        
        if (File::exists($policyFile)) {
            $this->warn("Policy {$policyName} already exists. Skipping...");
            return;
        }

        $permissionName = $this->getPermissionName($resourceName);
        $modelClassShort = class_basename($modelClass);
        
        $stub = $this->getPolicyStub($modelClass, $modelClassShort, $permissionName);
        
        File::put($policyFile, $stub);
        
        $this->info("✓ Generated {$policyName}");
    }

    protected function getPermissionName($resourceName)
    {
        // Convert PascalCase to snake_case
        // e.g., SurveyQuestion => survey_question
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $resourceName));
    }

    protected function getPolicyStub($modelClass, $modelClassShort, $permissionName)
    {
        return <<<PHP
<?php

namespace App\Policies;

use App\Models\User;
use {$modelClass};
use Illuminate\Auth\Access\HandlesAuthorization;

class {$modelClassShort}Policy
{
    use HandlesAuthorization;

    public function viewAny(User \$user): bool
    {
        return \$user->can('view_any_{$permissionName}');
    }

    public function view(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('view_{$permissionName}');
    }

    public function create(User \$user): bool
    {
        return \$user->can('create_{$permissionName}');
    }

    public function update(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('update_{$permissionName}');
    }

    public function delete(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('delete_{$permissionName}');
    }

    public function deleteAny(User \$user): bool
    {
        return \$user->can('delete_any_{$permissionName}');
    }

    public function forceDelete(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('force_delete_{$permissionName}');
    }

    public function forceDeleteAny(User \$user): bool
    {
        return \$user->can('force_delete_any_{$permissionName}');
    }

    public function restore(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('restore_{$permissionName}');
    }

    public function restoreAny(User \$user): bool
    {
        return \$user->can('restore_any_{$permissionName}');
    }

    public function replicate(User \$user, {$modelClassShort} \$model): bool
    {
        return \$user->can('replicate_{$permissionName}');
    }

    public function reorder(User \$user): bool
    {
        return \$user->can('reorder_{$permissionName}');
    }
}

PHP;
    }
}
