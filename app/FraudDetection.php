<?php

namespace App;

use ArrayIterator;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;

class FraudDetection extends Model
{
    private $transactions;
    private $startTime;
    private $endTime;
    private $threshold;

    /**
     * FraudDetection constructor.
     *
     * @param $transactions
     * @param $startTime
     * @param $endTime
     * @param $threshold
     */
    public function __construct($transactions, $startTime, $endTime, $threshold)
    {
        $this->transactions = $transactions;
        $this->startTime    = strtotime($startTime);
        $this->endTime      = strtotime($endTime);
        $this->threshold    = (int) $threshold;
    }

    /**
     * Find fraudulent transactions.
     *
     * @return array
     */
    public function findFraudulentTransactions()
    {
        $transactions = $this->createTransactions($this->transactions);

        return $this->checkFraudulentTransactions($transactions);
    }

    /**
     * Check fraudulent transactions.
     *
     * @param $transactions
     * @return array
     */
    private function checkFraudulentTransactions($transactions) {
        $fraudulentCreditCards = array();
        $sumOfAmount = array();
        $iterator = new ArrayIterator($transactions);
        while ($iterator->valid()) {
            $transaction = $iterator->current();
            $inBetween = ($transaction->getTimeStamp() >= $this->startTime) && ($transaction->getTimeStamp() <= $this->endTime) ? true: false;
            if ($inBetween) {
                if (array_key_exists($transaction->getCcHash(), $sumOfAmount)) {
                    $sumOfAmount[$transaction->getCcHash()] += $transaction->getAmount();
                } else {
                    $sumOfAmount[$transaction->getCcHash()] = $transaction->getAmount();
                }
            }
            $iterator->next();
        }
        $iterator = new ArrayIterator($sumOfAmount);
        while ($iterator->valid()) {
            if ($iterator->current() > $this->threshold) {
                array_push($fraudulentCreditCards, $iterator->key());
            }
            $iterator->next();
        }

        return $fraudulentCreditCards;
    }

    /**
     * Create transactions.
     *
     * @param $transactions
     * @return array
     */
    private function createTransactions($transactions) {
        $result = array();
        foreach ($transactions as $transaction) {
            $explodedString = explode(",", $transaction);
            if (sizeof($explodedString) == 3) {
                $ccHash = $explodedString[0];
                $timestamp = strtotime($explodedString[1]);
                $amount = 0;
                if (is_numeric($explodedString[2])) {
                    $amount = (int) $explodedString[2];
                }
                array_push($result, new Transaction($ccHash, $timestamp, $amount));
            }
        }

        return $result;
    }
}
