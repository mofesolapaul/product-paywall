<?php

declare(strict_types=1);

use App\VerifyTransaction;
use Httpful\Request;

require_once 'vendor/autoload.php';

$ref = getUrlParam(env('TXN_ID_GET_PARAM', 'reference'));
$verifyTransaction = new VerifyTransaction();

if ($verifyTransaction->verify($ref)) {
    $response = Request::get(env('PRODUCT_URL'))
        ->addHeader('Authorization', 'Bearer ' . env('PAYMENT_PROVIDER_SECRET_KEY'))
        ->expectsType('application/octet-stream')
        ->send();
    readfile($response);
}
