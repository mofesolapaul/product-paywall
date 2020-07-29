<?php

declare(strict_types=1);

use Dotenv\Dotenv;

const DATA_DIR = __DIR__ . '/../storage';

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();
$dotenv->required(['PAYMENT_PROVIDER', 'PRODUCT_URL', 'SUCCESS_REDIRECT']);

function env($param, $default = null)
{
    return $_ENV[$param] ?: $default;
}

function getUrlParam($param, $default = null)
{
    return $_GET[$param] ?: $default;
}

function verificationUrl($reference)
{
    switch (env('PAYMENT_PROVIDER')) {
        case 'paystack':
            return 'https://api.paystack.co/transaction/verify/' . $reference;
        default:
            return null;
    }
}
