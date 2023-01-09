# Mathmatical-Operation

Installation

Step 1: Create the composer.json file to your root directory and define

    {
        "minimum-stability": "dev"

    }

Step 2: Composer Via Composer command line:

    $ composer require vineet/mathmatical-operation

How to use this package

Step 1: Use this way to access this package class 

    $class = new \Vineet\MathmaticalOperation\Calculation()


Step 2: To access this method (add,subtract,multiply,division) like 

    $result=$class->add($val1,$val2);


Step 3: Create your own file where test your package use below code to access

    require_once 'vendor/autoload.php';
    $class = new \Vineet\MathmaticalOperation\Calculation();
    $result=$class->add(10,20);
    echo $result;

Step 4: Function define like this

    function add($a,$b){
        return $a+$b;
    }
    function subtract($a,$b){
        return $a+$b;
    }
    function multiply($a,$b){
        return $a+$b;
    }

    function division($a,$b){
        return $a/$b;
    }