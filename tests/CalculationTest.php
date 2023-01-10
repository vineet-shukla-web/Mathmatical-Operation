
<?php
use PHPUnit\Framework\TestCase;
use Vineet\MathmaticalOperation;
class CalculationTest extends TestCase
{

    //*=========For add function ===================*//
    public function testAdd()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->add(10, 20);
        $this->assertEquals(20, $result);
    }

    //*=========For subtarct function ===================*//
    public function testSubtract()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->subtract(20, 10);
        $this->assertEquals(10, $result);
    }
    //*=========For multiply function ===================*//
    public function testMultiply()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->multiply(20, 10);
        $this->assertEquals(200, $result);
    }

    //*=========For division function ===================*//
    public function testDivision()
    {
        $calculation = new \Vineet\MathmaticalOperation\Calculation();
        $result = $calculation->division(20, 10);
        $this->assertEquals(2, $result);
    }
}
