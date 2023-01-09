# Mathmatical-Operation

Installation

Step 1: Create the composer.json file to your root directory and define

    {
        "minimum-stability": "dev"

    }

Step 2: Composer Via Composer command line:

    $ composer require vineet/mathmatical-operation


Step 3: Use this way to access this package class 

    $class = new \Vineet\MathmaticalOperation\Calculation()


Step 4: To access this method (add,subtract,multiply,division) like 

    $result=$class->add($val1,$val2);


Step 5: Craete your own file where test your package.

Step 6: Function define like this

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