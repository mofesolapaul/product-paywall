<?php

declare(strict_types=1);

namespace App;

use Httpful\Exception\ConnectionErrorException;
use Httpful\Request;

class VerifyTransaction
{
    /**
     * @var TransactionStore
     */
    private $transactionStore;

    public function __construct()
    {
        $this->transactionStore = new TransactionStore();
    }

    /**
     * @param string $transactionRef
     * @return bool|null
     * @throws ConnectionErrorException
     */
    public function verify(?string $transactionRef)
    {
        if (!$transactionRef) {
            return null;
        }
        $url = verificationUrl($transactionRef);
        $status = Request::get($url)
            ->addHeader('Authorization', 'Bearer ' . env('PAYMENT_PROVIDER_SECRET_KEY'))
            ->expectsJson()
            ->send()->body->status;

        if ($status === true) {
            $status = $this->transactionStore->saveTransactionRef($transactionRef);
        }

        return $status;
    }
}
