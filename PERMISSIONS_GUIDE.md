# Permissions Guide

## Overview
This application uses Spatie Laravel Permission package with Filament Shield for role-based access control.

## Roles

### Super Admin
- Has all permissions
- Full access to all features
- Credentials: `admin@tracerstudy.test / password`

### Staff
- Can view, create, and update most resources
- Limited delete capabilities
- Credentials: `staff@tracerstudy.test / password`

### Viewer
- Read-only access
- Can only view resources
- Credentials: `viewer@tracerstudy.test / password`

## Permission Naming Convention

Permissions follow this pattern: `{action}_{resource}`

### Actions
- `view_any_{resource}` - View list of resources
- `view_{resource}` - View single resource detail
- `create_{resource}` - Create new resource
- `update_{resource}` - Edit existing resource
- `delete_{resource}` - Delete single resource
- `delete_any_{resource}` - Bulk delete resources
- `force_delete_{resource}` - Permanently delete soft-deleted resource
- `force_delete_any_{resource}` - Bulk force delete
- `restore_{resource}` - Restore soft-deleted resource
- `restore_any_{resource}` - Bulk restore
- `replicate_{resource}` - Duplicate resource

### Resources
- `alumni` - Alumni management
- `campus` - Campus/University
- `department` - Academic departments
- `faculty` - Faculty management
- `program` - Study programs
- `employer` - Employer/Company
- `employment` - Employment history
- `survey_question` - Survey questions
- `survey_response` - Survey responses
- `tracer_study_session` - Survey sessions
- `report` - Reports
- `user` - User management
- `role` - Role management

## Examples

- `view_any_alumni` - Can view alumni list
- `create_survey_question` - Can create survey questions
- `delete_employment` - Can delete employment records
- `update_user` - Can edit users

## How It Works

### In Filament Resources

Resources use `HasPageShield` trait which automatically checks permissions:

```php
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class AlumniResource extends Resource
{
    use HasPageShield;
    // ...
}
```

### Checking Permissions in Code

```php
// Check if user has permission
if (auth()->user()->can('create_alumni')) {
    // Allow action
}

// Check if user has role
if (auth()->user()->hasRole('super_admin')) {
    // Super admin actions
}

// Check if user has any of these permissions
if (auth()->user()->hasAnyPermission(['view_any_alumni', 'create_alumni'])) {
    // Allow action
}
```

### In Controllers (for Alumni Frontend)

Alumni portal uses separate authentication (`alumni` guard) and doesn't use permissions - it's a self-service portal for alumni to manage their own data.

## Regenerating Permissions

To regenerate permissions after adding new resources:

```bash
php artisan db:seed --class=PermissionsSeeder
```

This will:
1. Create all resource permissions
2. Assign all permissions to Super Admin role
3. Assign appropriate permissions to Staff and Viewer roles

## Testing Permissions

1. Login as Staff user: `staff@tracerstudy.test / password`
2. Try to delete a record - should be prevented
3. Try to create/edit a record - should work
4. Check navigation menu - only resources with `view_any` permission should appear

Login as Viewer user: `viewer@tracerstudy.test / password`
- Should only see resources (read-only)
- No create/edit/delete buttons should appear

## Troubleshooting

### Permission not working?
1. Clear cache: `php artisan permission:cache-reset`
2. Re-run seeder: `php artisan db:seed --class=PermissionsSeeder`
3. Check if user has the role: Check in database `model_has_roles` table
4. Check if role has permission: Check in database `role_has_permissions` table

### Navigation menu shows resources without permission?
Resources should check `canViewAny()` automatically with HasPageShield trait. If not working, check if:
- Resource uses `HasPageShield` trait
- Permission exists in database
- User's role has the permission

### Custom Permissions

To add custom permissions (e.g., for specific actions):

```php
// In PermissionsSeeder.php
$customPermissions = [
    'export_reports',
    'send_notifications',
    'approve_submissions',
];

foreach ($customPermissions as $permission) {
    Permission::firstOrCreate([
        'name' => $permission,
        'guard_name' => 'web',
    ]);
}
```

Then assign to roles as needed.
