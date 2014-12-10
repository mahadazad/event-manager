<?php
namespace EventManager\Response;

use EventManager\Command\CommandInterface;

class Response implements ResponseInterface
{
    /**
     * @var CommandInterface $cmd
     */
    protected $command;

    /**
     * @var mixed $result
     */
    protected $result;

    /**
     * @param CommandInterface $cmd
     * @param mixed            $result
     */
    public function __construct(CommandInterface $cmd, $result = null)
    {
        $this->setCommand($cmd);
        $this->setResult($result);
    }

    /**
     * @param CommandInterface $cmd
     */
    public function setCommand(CommandInterface $cmd)
    {
        $this->command = $cmd;
    }

    /**
     * @return CommandInterface
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result = null)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
