<?php
namespace EventManager\Tests;

use EventManager\EventManager;

class EventManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testEventCalls()
    {
        $em = new EventManager();

        $handler1 = $em->attach('say.hello', function () {
            return 'hello';
        },10);

        $handler2 = $em->attach('say.hello', function () {
            return 'hello!!!';
        },200);

        $handler3 = $em->attach('say.hello', function () {
            return 'heeellloooo';
        },300);

        $em->detach($handler3);

        $response = $em->trigger('say.hello');

        $this->assertInstanceOf('\EventManager\Command\Command', $handler1);
        $this->assertInstanceOf('\EventManager\Command\Command', $handler2);
        $this->assertInstanceOf('\EventManager\Command\Command', $handler3);
        $this->assertFalse($handler1 === $handler2);
        $this->assertInstanceOf('\EventManager\Response\ResponseCollection', $response);
        $this->assertEquals('hello!!!', $response[0]->getResult());
        $this->assertEquals(2, count($response));
    }
}
