<?php

use App\Http\Responses\ApiCode;
use App\Traits\WrapsApiResponse;

function findCategoryById($categories, $id)
{
    foreach ($categories as $category) {
        if ($category['id'] === $id) {
            return $category;
        }
    }
    return null;
}

function notFound()
{
    return WrapsApiResponse::respondError('Item doesn\'t exist anymore', ApiCode::NotFound);
}