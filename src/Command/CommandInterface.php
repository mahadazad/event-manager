<?php
namespace EventManager\Command;

interface CommandInterface
{
    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback = null);

    /**
     * @return callable
     */
    public function getCallback();

    /**
     * @param mixed
     * @return mixed
     */
    public function __invoke();
}
