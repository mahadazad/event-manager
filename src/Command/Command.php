<?php
namespace EventManager\Command;

class Command implements CommandInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->setCallback($callback);
    }

    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback = null)
    {
        $this->callback = $callback;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param mixed
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->getCallback(), func_get_args());
    }
}
