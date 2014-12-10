<?php
namespace EventManager\Tests\Response;
use EventManager\EventManager;
use EventManager\Command\Command;
use EventManager\Response\Response;
use EventManager\Response\ResultIterator;
use EventManager\Response\ResponseCollection;

class ResponseCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $collection;
    protected $cmds;

    public function setUp()
    {
        $collection = new ResponseCollection();
        $cmds = array();
        foreach (range(1,3) as $num) {
            $cmd = new Command(function() use ($num) {
                return $num;
            });
            $cmds[] = $cmd;
            $response = new Response($cmd, $num);

            $collection->add($response);
        }

        $this->collection = $collection;
        $this->cmds = $cmds;
    }

    public function testCollection()
    {
        $collection = $this->collection;
        
        $this->assertEquals(3, count($collection));
        $this->assertEquals(3, $collection[2]->getResult());
    }

    public function testResultIterator()
    {
        $collection = $this->collection;

        $i = 0;
        foreach (new ResultIterator($collection) as $num) {
            $i++;
            $this->assertEquals($i, $num);
        }
    }

    public function testGetCommandResult()
    {
        $collection = $this->collection;
        foreach($collection->getCommandResult($this->cmds[1]) as $num) {
            $this->assertEquals(2, $num->getResult());
        }
    }

    public function testGetCommandResultWithResultIterator()
    {
        $collection = $this->collection;
        foreach(new ResultIterator($collection->getCommandResult($this->cmds[1])) as $num) {
            $this->assertEquals(2, $num);
        }

    }

    public function testToArray()
    {
        $arr = $this->collection->toArray();
        foreach (range(1,3) as $i => $num) {
            $this->assertEquals($arr[$i], $num);
        }
    }

    /**
     * @expectedException \EventManager\Response\Exception\ResultNotFound
     */
    public function testInvalidArgument()
    {
        $collection = $this->collection;
        $collection[10];
    }
}