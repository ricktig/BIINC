<?php
/**
 * Define MyClass
 */
class MyClass
{
    public $public = 'Public'; //declare a public variable which can be seen in MyClass, MyClass2, 
    protected $protected = 'Protected';
    private $private = 'Private';

    function printHello()
    {
        echo 'MyClass printHello Public: ' . $this->public. '<br/>';
        echo 'MyClass printHello Protected: ' . $this->protected. '<br/>';
        echo 'MyClass printHello Private: ' . $this->private. '<br/>';
    }
} //end class MyClass

$obj = new MyClass();
echo 'MyClass Public:' . $obj->public . '<br/>'; // Works - public variable available outside MyClass
//echo $obj->protected; // Fatal Error - protected variable only available in MyClass and MyClass2 (child)
//echo $obj->private; // Fatal Error - private variable only available in MyClass
$obj->printHello(); // Calls function to show Public, Protected and Private variables in MyClass


/**
 * Define MyClass2
 */
class MyClass2 extends MyClass
{
    // We can redeclare the public and protected method, but not private (really??)
    protected $protected = 'Protected2';
	
	//declare a private variable
	//private $private = 'Private2';

    function printHello()
    {
        echo 'MyClass2 printHello Public: ' . $this->public . '<br/>';
        echo 'MyClass2 printHello Protected: ' . $this->protected . '<br/>';
        echo 'MyClass2 printHello Private: ' . $this->private . '<br/>';
    }
} //end class MyClass2

$obj2 = new MyClass2();
echo 'MyClass2 Public: ' . $obj->public; // Works - public variable from MyClass available outside MyClass
//echo $obj2->protected; // Fatal Error - protected variable only available in MyClass2
//echo $obj2->private; // Undefined - private variable not available outside MyClass2
$obj2->printHello(); // Shows Public, Protected2, Undefined error
?>
