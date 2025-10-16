<?php

use Illuminate\Support\Facades\Vite;

if (! function_exists('vite_asset')) {
    function vite_asset(string $path): string
    {
        return Vite::asset($path);
    }
}

// public
if (! function_exists('core_public_asset')) {
    function core_public_asset(string $module = 'base', string $file = null): string
    {
        return platform_public('core', $module) . ($file ? '/' . ltrim($file, '/') : '');
    }
}

if (! function_exists('theme_public_asset')) {
    function theme_public_asset(string $module, string $file = null): string
    {
        return platform_public('themes', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

if (! function_exists('package_public_asset')) {
    function package_public_asset(string $module, string $file = null): string
    {
        return platform_public('packages', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

// resouces
if (! function_exists('core_asset')) {
    function core_asset(string $module, string $file = null): string
    {
        return platform_resource('core', $module) . ($file ? '/' . ltrim($file, '/') : '');
    }
}

if (! function_exists('theme_asset')) {
    function theme_asset(string $module, string $file = null): string
    {
        return platform_resource('themes', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

if (! function_exists('package_asset')) {
    function package_asset(string $module, string $file = null): string
    {
        return platform_resource('packages', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

if (! function_exists('vite_core_asset')) {
    function vite_core_asset(string $module, string $path): string
    {
        return vite_asset(core_asset($module, $path));
    }
}

if (! function_exists('vite_theme_asset')) {
    function vite_theme_asset(string $module, string $path): string
    {
        return vite_asset(theme_asset($module, $path));
    }
}

if (! function_exists('vite_package_asset')) {
    function vite_package_asset(string $module, string $path): string
    {
        return vite_asset(package_asset($module, $path));
    }
}
