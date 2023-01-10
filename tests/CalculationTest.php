

<?php 
use PHPUnit\Framework\TestCase;
 class CalculationTest extends TestCase
{
  
    //*=========For add function ===================*//
    public function testAdd(){
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result=$calculation->add(10,20);
        $this->assertEquals(30,$result);
    }

    //*=========For subtarct function ===================*//
    public function testSubtract(){
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result=$calculation->subtract(20,10);
        $this->assertEquals(40,$result);
    }
}

