<?php
namespace JmesPath\Tests;

use JmesPath\FnDispatcher;

class FnDispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertsToString()
    {
        $fn = new FnDispatcher();
        $table = [];
        $this->assertEquals('foo', $fn('to_string', ['foo'], $table));
        $this->assertEquals('1', $fn('to_string', [1], $table));
        $this->assertEquals('["foo"]', $fn('to_string', [['foo']], $table));
        $std = new \stdClass();
        $std->foo = 'bar';
        $this->assertEquals('{"foo":"bar"}', $fn('to_string', [$std], $table));
        $this->assertEquals('foo', $fn('to_string', [new _TestStringClass()], $table));
        $this->assertEquals('"foo"', $fn('to_string', [new _TestJsonStringClass()], $table));
    }
}

class _TestStringClass
{
    public function __toString()
    {
        return 'foo';
    }
}

class _TestJsonStringClass implements \JsonSerializable
{
    public function __toString()
    {
        return 'no!';
    }

    public function jsonSerialize()
    {
        return 'foo';
    }
}
