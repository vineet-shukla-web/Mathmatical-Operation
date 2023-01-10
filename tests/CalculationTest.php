

<?php 
use PHPUnit\Framework\TestCase;
 class CalculationTest extends TestCase
{
  
    public function testAdd(){
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result=$calculation->add(10,20);
        $this->assertEquals(50,$result);
        //.\vendor\bin\phpunit tests   //command to execute test case 
    }
}

