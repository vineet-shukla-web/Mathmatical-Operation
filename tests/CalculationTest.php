
<?php

use PHPUnit\Framework\TestCase;
use Vineet\MathmaticalOperation;

class CalculationTest extends TestCase
{

    //*=========For add function ===================*//
    public function testAdd()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->add(5, 20);
        $this->assertEquals(5, $result,"Actual value is not equals to expected");
    }

    //*=========For subtarct function ===================*//
    public function testSubtract()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->subtract(20, 10,);
        $this->assertEquals(10, $result,"Actual value is not equals to expected");
    }
    //*=========For multiply function ===================*//
    public function testMultiply()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->multiply(20, 10);
        $this->assertEquals(200, $result,"Actual value is not equals to expected");
    }

    //*=========For division function ===================*//
    public function testDivision()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->division(20, 10);
        $this->assertEquals(2, $result,"Actual value is not equals to expected");
    }


    // *=============Check all order of the day=============*//
    public function testAllOrdersOfDay(){
        $response = new \Vineet\MathmaticalOperation\ConnectAPI('token');
        $result= $response->getAllOrdersOfDay(123);
        $this->assertEquals(2, $result,"Actual value is not equals to expected");
    }
    

}
