<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppSettingsRequest;
use App\Services\AppSettingsService;

class AppSettingsController extends Controller
{
    protected $appSettingsService;

    public function __construct(AppSettingsService $appSettingsService)
    {
        $this->appSettingsService = $appSettingsService;
    }

    public function updateGlobalDiscount(UpdateAppSettingsRequest $request)
    {
        return $this->appSettingsService->update($request);
    }
}