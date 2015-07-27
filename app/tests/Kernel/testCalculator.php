<?php
	class testCalculator extends PHPUnit_Framework_TestCase
	{
		public function testAdd()
		{
			require 'Calculator.php';
			$Controller = new Calculator;
			$expected = 5;
			$this->assertEquals($expected, $Controller->add(3,2));
		}
	}
?>