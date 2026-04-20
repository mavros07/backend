<?php

namespace App\Support;

final class VehicleImageUrl
{
    /**
     * Public vehicle image URL: supports local `asset/...` or `storage/...` paths and absolute http(s) URLs.
     */
    public static function url(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return asset($path);
    }

    public static function isRemote(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return preg_match('#^https?://#i', $path) === 1;
    }
}
