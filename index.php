<?php

declare(strict_types=1);

use App\VerifyTransaction;
use Httpful\Request;

require_once 'vendor/autoload.php';

$ref = getUrlParam(env('TXN_ID_GET_PARAM', 'reference'));
$verifyTransaction = new VerifyTransaction();

if ($verifyTransaction->verify($ref)) {
    $response = Request::get(env('PRODUCT_URL'))
        ->expectsType('application/octet-stream')
        ->send()->body;

    header('Content-Disposition: attachment; filename="' . env('PRODUCT_FILENAME') . '"');
    header("Content-Type: application/octet-stream;");

    echo $response;
} else {
    header('Location: ' . env('FAILURE_REDIRECT'));
}
