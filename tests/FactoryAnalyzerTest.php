<?php


namespace TheCodingMachine\ServiceProvider\Utils;


class FactoryAnalyzerTest extends \PHPUnit_Framework_TestCase
{
    public function testNoArgument() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container) {
            return new \stdClass();
        });
        $this->assertFalse($result);
    }

    public function testArgumentNoUsage() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container, $previous) {
            return new \stdClass();
        });
        $this->assertFalse($result);
    }

    public function testArgumentUsage() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container, $previous) {
            return $previous;
        });
        $this->assertTrue($result);
    }

    public function testNoArgumentButFuncGetArgs() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container) {
            $args = func_get_args();
            return $args[1];
        });
        $this->assertTrue($result);
    }

    public function testVariadics() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function(...$args) {
            return $args[1];
        });
        $this->assertTrue($result);
    }

    public function testVariadics2() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container, ...$args) {
            return $args[0];
        });
        $this->assertTrue($result);
    }

    public function testVariableByName() {
        $factoryAnalyser = new FactoryAnalyzer();
        $result = $factoryAnalyser->isPreviousArgumentUsed(function($container, $previous) {
            $previousName = 'previous';
            return $$$previousName;
        });
        $this->assertTrue($result);
    }

}
