<?php
namespace EventManager\Tests\Command;

use EventManager\Command\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        $lambda = function ($name) {
            return "hello $name";
        };

        $cmd = new Command($lambda);

        $this->assertEquals('hello mahad', $cmd('mahad'));
    }
}
