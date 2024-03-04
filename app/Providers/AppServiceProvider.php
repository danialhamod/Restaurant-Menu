<?php

namespace App\Providers;

use App\Interfaces\AppSettingsRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Repositories\AppSettingsRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(AppSettingsRepositoryInterface::class, AppSettingsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
