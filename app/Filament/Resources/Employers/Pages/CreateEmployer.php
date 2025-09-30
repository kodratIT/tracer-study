<?php

namespace App\Filament\Resources\Employers\Pages;

use App\Filament\Resources\Employers\EmployerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployer extends CreateRecord
{
    protected static string $resource = EmployerResource::class;
}
