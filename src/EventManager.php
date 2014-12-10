<?php
namespace EventManager;

use EventManager\Response\Response;
use EventManager\Response\ResponseCollection;
use EventManager\Command\Command;

class EventManager implements EventManagerInterface
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @var \SplObjectStorage
     */
    protected $commands;

    public function __construct()
    {
        $this->commands = new \SplObjectStorage();
    }

    /**
     * @param  string                   $event
     * @param  array                    $args
     * @return false|ResponseCollection
     */
    public function trigger($event, array $args = null)
    {
        if (!empty($this->listeners[$event])) {
            $responseCollection = new ResponseCollection();
            foreach ($this->listeners[$event] as $cmd) {
                $result = call_user_func_array($cmd, (array) $args);
                $response = new Response($cmd, $result);
                $responseCollection->add($response);
            }

            return $responseCollection;
        }

        return false;
    }

    /**
     * @param  string           $event
     * @param  callable         $callback
     * @param  int              $priority
     * @return CommandInterface
     */
    public function attach($event, callable $callback = null, $priority = 1)
    {
        $event = $this->normalizeEventName($event);
        if (empty($this->listeners[$event])) {
            $this->listeners[$event] = new \SplPriorityQueue();
        }

        $command = new Command($callback, $priority);
        $this->listeners[$event]->insert($command, $priority);

        $meta = new \stdClass();
        $meta->priority = $priority;
        $meta->event = $event;
        $this->commands->attach($command, $meta);

        return $command;
    }

    /**
     * @param  CommandInterface $listener
     * @return void
     */
    public function detach($listener)
    {
        $meta = $this->commands[$listener];
        $event = $meta->event;

        $listeners = new \SplPriorityQueue();

        foreach ($this->listeners[$event] as $cmd) {
            if ($cmd !== $listener) {
                $listeners->insert($cmd, $meta->priority);
            }
        }
        $this->commands->detach($listener);
        $this->listeners[$event] = $listeners;
    }

    /**
     * @param  string $event
     * @return void
     */
    public function clearListeners($event)
    {
        $this->listeners = new \SplPriorityQueue();
        $this->commands->removeAll();
    }

    /**
     * @param  string $eventName
     * @return string
     */
    protected function normalizeEventName($eventName)
    {
        return strtolower(trim($eventName));
    }
}
