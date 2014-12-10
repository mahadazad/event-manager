<?php
namespace EventManager\Response;

use EventManager\Command\CommandInterface;

interface ResponseInterface
{
    /**
     * @param CommandInterface $cmd
     */
    public function setCommand(CommandInterface $cmd);

    /**
     * @return CommandInterface
     */
    public function getCommand();

    /**
     * @param mixed $result
     */
    public function setResult($result = null);

    /**
     * @return mixed
     */
    public function getResult();
}
