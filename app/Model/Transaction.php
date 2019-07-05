<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    private $ccHash;
    private $timeStamp;
    private $amount;

    /**
     * Transaction constructor.
     *
     * @param $ccHash
     * @param $timeStamp
     * @param $amount
     */
    public function __construct($ccHash, $timeStamp, $amount)
    {
        $this->ccHash = $ccHash;
        $this->timeStamp = $timeStamp;
        $this->amount = $amount;
    }

    /**
     * Get cc hash.
     *
     * @return mixed
     */
    public function getCcHash()
    {
        return $this->ccHash;
    }

    /**
     * Get timestamp.
     *
     * @return mixed
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Get amount.
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
