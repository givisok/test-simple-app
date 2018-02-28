<?php

namespace Tests\Helpers;

trait CheckoutTrait
{
    public function goodCheckoutData(): array
    {
        return require(__DIR__ . '/../Unit/data/GoodCheckoutInput.php');
    }

    public function badCheckoutData(): array
    {
        return require(__DIR__ . '/../Unit/data/BadCheckoutInput.php');
    }

    public function badValidatorData(): array
    {
        return require(__DIR__ . '/../Unit/data/BadCheckoutValidation.php');
    }
}