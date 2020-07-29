<?php

declare(strict_types=1);

namespace App;

use SleekDB\SleekDB;

class TransactionStore
{
    /**
     * @var SleekDB
     */
    private $store;

    public function __construct()
    {
        $this->store = SleekDB::store('transactions', DATA_DIR);
    }

    /**
     * @param $txnRef
     * @return bool
     * @throws \Exception
     */
    private function exists($txnRef)
    {
        $condition = $this->store->where('reference', '=', $txnRef)->fetch();
        return count($condition) > 0;
    }

    /**
     * @param $txnRef
     * @return bool
     * @throws \Exception
     */
    public function saveTransactionRef($txnRef)
    {
        if ($this->exists($txnRef)) {
            return false;
        }
        $this->store->insert(
            [
                'reference' => $txnRef
            ]
        );
        return true;
    }
}