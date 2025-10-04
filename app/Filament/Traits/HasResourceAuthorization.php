<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasResourceAuthorization
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_any_' . static::getPermissionName());
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_' . static::getPermissionName());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('update_' . static::getPermissionName());
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete_' . static::getPermissionName());
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete_any_' . static::getPermissionName());
    }

    public static function canForceDelete(Model $record): bool
    {
        return auth()->user()->can('force_delete_' . static::getPermissionName());
    }

    public static function canForceDeleteAny(): bool
    {
        return auth()->user()->can('force_delete_any_' . static::getPermissionName());
    }

    public static function canRestore(Model $record): bool
    {
        return auth()->user()->can('restore_' . static::getPermissionName());
    }

    public static function canRestoreAny(): bool
    {
        return auth()->user()->can('restore_any_' . static::getPermissionName());
    }

    public static function canReplicate(Model $record): bool
    {
        return auth()->user()->can('replicate_' . static::getPermissionName());
    }

    /**
     * Get the permission name for this resource
     * Override this method in your resource if needed
     */
    protected static function getPermissionName(): string
    {
        // Get model class name
        $model = static::getModel();
        $modelName = class_basename($model);
        
        // Convert to snake_case (e.g., Alumni => alumni, SurveyQuestion => survey_question)
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $modelName));
    }
}
