<?php
namespace EventManager\Response;

use EventManager\Command\CommandInterface;
use EventManager\Response\FilterIterator as ResponseFilterIterator;
use EventManager\Response\Exception\ResultNotFound;

class ResponseCollection implements \Iterator, \Countable, \ArrayAccess
{
    /**
     * @var ResponseInterface[]
     */
    protected $results;

    /**
     * @var int
     */
    protected $postion = 0;

    public function __construct()
    {
        $this->results = new \ArrayObject();
    }

    /**
     * @param  ResponseInterface $response
     * @return void
     */
    public function add(ResponseInterface $response)
    {
        $this->results[] = $response;
    }

    /**
     * @param  CommandInterface $cmd
     * @return FilterIterator
     */
    public function getCommandResult(CommandInterface $cmd)
    {
        return new ResponseFilterIterator($this, $cmd);
    }

    /**
     * @return Result
     */
    public function current()
    {
        return $this->results[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return isset($this->results[$this->position]);
    }

    /**
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->results[$offset]);
    }

    /**
     * @return ResponseInterface
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->results[$offset];
        }

        throw new ResultNotFound();
    }

    /**
     * @param  int                       $offset
     * @param  ResponseInterface         $value
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        if (!is_int($offset) && $offset !== null) {
            throw new \InvalidArgumentException('$offset must be integer');
        }

        if (!$value instanceof ResponseInterface) {
            throw new \InvalidArgumentException('$value must be instance of ResponseInterface');
        }

        if ($offset) {
            $this->results[$offset] = $value;
        } else {
            $this->results[] = $value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->results[$offset]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->results);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return iterator_to_array(new ResultIterator($this->results));
    }
}
