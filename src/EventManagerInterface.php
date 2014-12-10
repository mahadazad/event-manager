<?php
namespace EventManager;

interface EventManagerInterface
{
    /**
     * @param  string                   $event
     * @param  array                    $args
     * @return false|ResponseCollection
     */
    public function trigger($event, array $args = null);

    /**
     * @param  string           $event
     * @param  callable         $callback
     * @param  int              $priority
     * @return CommandInterface
     */
    public function attach($event, callable $callback = null, $priority = 1);

    /**
     * @param  CommandInterface $listener
     * @return bool
     */
    public function detach($listener);

    /**
     * @param  string $event
     * @return void
     */
    public function clearListeners($event);
}
