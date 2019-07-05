<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\FraudDetection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FraudDetectionTest extends TestCase
{
    /**
     * Fraud detection unit test.
     *
     * @return void
     */
    public function testFraudDetection()
    {
        $startTime  = '2014-04-29T00:00:00';
        $endTime    = '2014-04-29T23:00:00';
        $threshold  = 30.00;

        $transactions = $this->createTransactions();
        $fraudDetection = new FraudDetection($transactions, $startTime, $endTime, $threshold);
        $resultedFraudulentTransactions = $fraudDetection->findFraudulentTransactions();

        $expectedFraudulentTransactions = array(
            '10d7ce2f43e35fa57d1bbf8b1e3'
        );

        $this->assertEquals($expectedFraudulentTransactions, $resultedFraudulentTransactions);
    }

    /**
     * Create transactions for test.
     *
     * @return array
     */
    private function createTransactions() {
        $transactions = array (
            '10d7ce2f43e35fa57d1bbf8b1e2,2014-04-29T13:15:54,10.00',
            '10d7ce2f43e35fa57d1bbf8b1e3,2014-04-29T13:15:58,15.00',
            '10d7ce2f43e35fa57d1bbf8b1e2,2014-04-29T14:00:00,20.00',
            '10d7ce2f43e35fa57d1bbf8b1e4,2014-04-29T13:10:00,25.00',
            '10d7ce2f43e35fa57d1bbf8b1e3,2014-04-29T13:20:00,30.00'
        );

        return $transactions;
    }
}
