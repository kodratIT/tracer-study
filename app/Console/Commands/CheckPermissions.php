<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CheckPermissions extends Command
{
    protected $signature = 'permissions:check {email?}';
    protected $description = 'Check permission status for users and roles';

    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            $this->checkUser($email);
        } else {
            $this->checkOverall();
        }
    }

    protected function checkOverall()
    {
        $this->info('=== Permission System Status ===');
        $this->newLine();

        // Check total permissions
        $totalPermissions = Permission::count();
        $this->info("Total Permissions: {$totalPermissions}");
        $this->newLine();

        // Check roles
        $this->info('=== Roles ===');
        $roles = Role::withCount('permissions', 'users')->get();
        
        foreach ($roles as $role) {
            $this->line("• {$role->name}");
            $this->line("  - Permissions: {$role->permissions_count}");
            $this->line("  - Users: {$role->users_count}");
        }
        $this->newLine();

        // Check users with roles
        $this->info('=== Users with Roles ===');
        $users = User::with('roles')->get();
        
        if ($users->isEmpty()) {
            $this->warn('No users found! Run ShieldSeeder to create default users.');
        } else {
            foreach ($users as $user) {
                $roleNames = $user->roles->pluck('name')->implode(', ') ?: 'No roles';
                $this->line("• {$user->email} - Roles: {$roleNames}");
            }
        }
        $this->newLine();

        // Sample permissions check
        $this->info('=== Sample Permissions ===');
        $samplePermissions = [
            'view_any_alumni',
            'create_alumni',
            'delete_alumni',
            'view_any_survey_question',
            'update_user',
        ];

        foreach ($samplePermissions as $permissionName) {
            $exists = Permission::where('name', $permissionName)->exists();
            $status = $exists ? '✓' : '✗';
            $this->line("{$status} {$permissionName}");
        }
    }

    protected function checkUser($email)
    {
        $user = User::where('email', $email)->with('roles', 'permissions')->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            return 1;
        }

        $this->info("=== User: {$user->name} ({$user->email}) ===");
        $this->newLine();

        // Check roles
        $this->info('Roles:');
        if ($user->roles->isEmpty()) {
            $this->warn('  No roles assigned');
        } else {
            foreach ($user->roles as $role) {
                $this->line("  • {$role->name}");
            }
        }
        $this->newLine();

        // Check direct permissions
        $this->info('Direct Permissions:');
        if ($user->permissions->isEmpty()) {
            $this->line('  None');
        } else {
            foreach ($user->permissions as $permission) {
                $this->line("  • {$permission->name}");
            }
        }
        $this->newLine();

        // Check all permissions (including from roles)
        $allPermissions = $user->getAllPermissions();
        $this->info("Total Permissions (via roles + direct): {$allPermissions->count()}");
        $this->newLine();

        // Test common permissions
        $this->info('Common Permission Checks:');
        $testPermissions = [
            'view_any_alumni' => 'View Alumni List',
            'create_alumni' => 'Create Alumni',
            'update_alumni' => 'Edit Alumni',
            'delete_alumni' => 'Delete Alumni',
            'force_delete_alumni' => 'Force Delete Alumni',
            'view_any_survey_question' => 'View Survey Questions',
            'create_survey_question' => 'Create Survey Questions',
        ];

        foreach ($testPermissions as $permission => $description) {
            $has = $user->can($permission);
            $status = $has ? '✓ Yes' : '✗ No';
            $this->line("  {$status} - {$description} ({$permission})");
        }
    }
}
