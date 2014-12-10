<?php
namespace EventManager\Response;

class ResultIterator implements \Iterator
{
    /**
     * @var Response[]
     */
    protected $responses;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @param  Response[]                $responses
     * @throws \InvalidArgumentException if $responses is not array or Traversable
     */
    public function __construct($responses)
    {
        if ($responses instanceof \Traversable) {
            $this->responses = iterator_to_array($responses, false);
        } elseif (is_array($responses)) {
            $this->responses = $responses;
        } else {
            throw new \InvalidArgumentException('$responses must be array or Traversable');
        }
    }

    /**
     * @return mixed
     */
    public function current()
    {
        $reponse = $this->responses[$this->position];

        return $reponse->getResult();
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
        return isset($this->responses[$this->position]) &&
               $this->responses[$this->position] instanceof Response;
    }
}
