<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Solo letras (incluye tildes) y espacios
        Validator::extend(
            'alpha_space',
            fn($attribute, $value) =>
            preg_match('/^[\pL\s]+$/u', $value) === 1
        );
        Validator::replacer(
            'alpha_space',
            fn($message, $attribute) =>
            ":attribute solo puede contener letras y espacios."
        );

        // 2. Alfanumérico + guiones bajos y medios
        Validator::extend(
            'alpha_dash',
            fn($attribute, $value) =>
            preg_match('/^[A-Za-z0-9_-]+$/', $value) === 1
        );
        Validator::replacer(
            'alpha_dash',
            fn($message, $attribute) =>
            ":attribute solo puede contener letras, números, guiones bajos y medios."
        );

        // 3. Números enteros o decimales con hasta dos dígitos
        Validator::extend(
            'decimal_2',
            fn($attribute, $value) =>
            preg_match('/^\d+(\.\d{1,2})?$/', $value) === 1
        );
        Validator::replacer(
            'decimal_2',
            fn($message, $attribute) =>
            ":attribute debe ser un número entero o decimal con hasta 2 decimales."
        );

        // 4. Fecha en formato YYYY-MM-DD
        Validator::extend(
            'date_iso',
            fn($attribute, $value) =>
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1
        );
        Validator::replacer(
            'date_iso',
            fn($message, $attribute) =>
            ":attribute debe tener el formato YYYY-MM-DD."
        );

        // 5. Solo dígitos (números enteros positivos)
        Validator::extend(
            'numeric_only',
            fn($attribute, $value) =>
            preg_match('/^\d+$/', $value) === 1
        );
        Validator::replacer(
            'numeric_only',
            fn($message, $attribute) =>
            ":attribute solo puede contener dígitos."
        );
    }
}
