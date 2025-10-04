<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run seeders
        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);
        $this->artisan('db:seed', ['--class' => 'PermissionsSeeder']);
    }

    public function test_super_admin_has_all_permissions()
    {
        $superAdmin = User::where('email', 'admin@tracerstudy.test')->first();
        
        $this->assertNotNull($superAdmin);
        $this->assertTrue($superAdmin->hasRole('super_admin'));
        
        $totalPermissions = Permission::count();
        $adminPermissions = $superAdmin->getAllPermissions()->count();
        
        $this->assertEquals($totalPermissions, $adminPermissions);
    }

    public function test_staff_has_limited_permissions()
    {
        $staff = User::where('email', 'staff@tracerstudy.test')->first();
        
        $this->assertNotNull($staff);
        $this->assertTrue($staff->hasRole('staff'));
        
        // Staff should have view and create permissions but limited delete
        $this->assertTrue($staff->can('view_any_alumni'));
        $this->assertTrue($staff->can('create_alumni'));
        
        // Staff should not have force delete permissions
        $this->assertFalse($staff->can('force_delete_alumni'));
    }

    public function test_viewer_has_only_view_permissions()
    {
        $viewer = User::where('email', 'viewer@tracerstudy.test')->first();
        
        $this->assertNotNull($viewer);
        $this->assertTrue($viewer->hasRole('viewer'));
        
        // Viewer should only have view permissions
        $this->assertTrue($viewer->can('view_any_alumni'));
        $this->assertTrue($viewer->can('view_alumni'));
        
        // Viewer should not have create/edit/delete permissions
        $this->assertFalse($viewer->can('create_alumni'));
        $this->assertFalse($viewer->can('update_alumni'));
        $this->assertFalse($viewer->can('delete_alumni'));
    }

    public function test_all_resource_permissions_exist()
    {
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
            'user',
        ];

        $actions = ['view_any', 'view', 'create', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permissionName = "{$action}_{$resource}";
                $permission = Permission::where('name', $permissionName)->first();
                
                $this->assertNotNull(
                    $permission,
                    "Permission '{$permissionName}' does not exist"
                );
            }
        }
    }

    public function test_roles_exist()
    {
        $requiredRoles = ['super_admin', 'staff', 'viewer'];

        foreach ($requiredRoles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            
            $this->assertNotNull($role, "Role '{$roleName}' does not exist");
        }
    }
}
