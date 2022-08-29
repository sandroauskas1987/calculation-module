<?php
use App\Services\DeliveryService\BaseDeliveryService;

class ServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected BaseDeliveryService $baseDeliveryService;
    
    protected function _before()
    {
        $this->baseDeliveryService = new BaseDeliveryService();
    }

    protected function _after()
    {

    }

    /**
     * @group unit
     */
    public function testGetAmount()
    {
        $expectedResult = [
            '150'   => [10,15],
            '2700'  => [9,300],
            '4.5'   => [3.26,1.5],
        ];

        foreach ($expectedResult as $amount => $params) {
            $this->assertEquals($amount, $this->baseDeliveryService->getAmount($params[0], $params[1]));
        }

    }
 
}