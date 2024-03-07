<?php

namespace App\Http\Controllers;

use App\Enums\AppSettingsKeys;
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

    public function getGlobalDiscount()
    {
        return $this->appSettingsService->get(AppSettingsKeys::GlobalDiscount);
    }
}