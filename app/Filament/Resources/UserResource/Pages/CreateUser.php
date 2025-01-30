<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Events\ShiftmeetingCreated;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;



    protected function handleRecordCreation(array $data): Model
    {   
        //$roles = $data["roles"];
        $record = static::getModel()::create(Arr::except($data, "roles"));
        //$record->assignRole($roles);
        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    
}
