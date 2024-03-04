<?php

namespace App\Services;

use App\Enums\AppSettingsKeys;
use App\Interfaces\AppSettingsRepositoryInterface;
use App\Traits\WrapsApiResponse as WrapsApiResponse;

class AppSettingsService
{
    use WrapsApiResponse;

    protected $appSettingsRepository;

    public function __construct(AppSettingsRepositoryInterface $appSettingsRepository)
    {
        $this->appSettingsRepository = $appSettingsRepository;
    }

    public function update($request)
    {
        $this->appSettingsRepository->update(AppSettingsKeys::GlobalDiscount, $request->post('discount'));
        return $this->respondSuccess();
    }
}
