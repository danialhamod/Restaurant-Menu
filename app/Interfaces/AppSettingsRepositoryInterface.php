<?php

namespace App\Interfaces;

interface AppSettingsRepositoryInterface
{
    public function update($id, array $attributes);
}
