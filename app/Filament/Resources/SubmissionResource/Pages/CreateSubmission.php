<?php

namespace App\Filament\Resources\SubmissionResource\Pages;

use App\Filament\Resources\SubmissionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateSubmission extends CreateRecord
{
    protected static string $resource = SubmissionResource::class;
}
