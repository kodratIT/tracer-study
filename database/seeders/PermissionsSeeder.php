<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all resources
        $resources = [
            'alumni',
            'campus',
            'department',
            'faculty',
            'program',
            'employer',
            'employment',
            'survey_question',
            'survey_response',
            'tracer_study_session',
            'report',
            'role',
            'user', // User management
        ];

        // Define permission actions
        $actions = [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'restore',
            'restore_any',
            'replicate',
        ];

        // Generate permissions for each resource
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action}_{$resource}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Additional custom permissions
        $customPermissions = [
            'page_Dashboard',
            'widget_TracerStudyOverviewWidget',
            'widget_AlumniEmploymentStatsWidget',
            'widget_AlumniTrendChartWidget',
        ];

        foreach ($customPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Update Super Admin role to have all permissions
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions(Permission::all());
        }

        // Update Staff role permissions
        $staffRole = Role::where('name', 'staff')->first();
        if ($staffRole) {
            $staffPermissions = Permission::where(function ($query) {
                $query->where('name', 'like', 'view%')
                    ->orWhere('name', 'like', 'create%')
                    ->orWhere('name', 'like', 'update%')
                    ->orWhere('name', 'like', 'page_%')
                    ->orWhere('name', 'like', 'widget_%');
            })->get();
            
            $staffRole->syncPermissions($staffPermissions);
        }

        // Update Viewer role permissions (read-only)
        $viewerRole = Role::where('name', 'viewer')->first();
        if ($viewerRole) {
            $viewerPermissions = Permission::where(function ($query) {
                $query->where('name', 'like', 'view%')
                    ->orWhere('name', 'like', 'page_%')
                    ->orWhere('name', 'like', 'widget_%');
            })->get();
            
            $viewerRole->syncPermissions($viewerPermissions);
        }

        $this->command->info('Permissions generated successfully!');
        $this->command->info('Total permissions: ' . Permission::count());
        $this->command->info('');
        $this->command->info('Role permissions:');
        $this->command->info('- Super Admin: ' . $superAdminRole->permissions->count() . ' permissions');
        $this->command->info('- Staff: ' . $staffRole->permissions->count() . ' permissions');
        $this->command->info('- Viewer: ' . $viewerRole->permissions->count() . ' permissions');
    }
}
