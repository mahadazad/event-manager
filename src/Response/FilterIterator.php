<?php
namespace EventManager\Response;

use EventManager\Command\CommandInterface;

class FilterIterator extends \FilterIterator
{
    /**
     * @param CommandInterface $cmd
     */
    protected $command;

    /**
     * @param ResponseCollection $iterator
     * @param CommandInterface   $cmd
     */
    public function __construct(\Iterator $iterator, CommandInterface $cmd)
    {
        if (!$iterator instanceof ResponseCollection) {
            throw new InvalidArgumentException('$iterator must be instance of EventManager\Response\ResponseCollection');
        }

        parent::__construct($iterator);
        $this->command = $cmd;
    }

    /**
     * @return boolean
     */
    public function accept()
    {
        if ($this->getInnerIterator()->current()->getCommand() === $this->command) {
            return true;
        }

        return false;
    }

    /**
     * @return Response[]
     */
    public function toArray()
    {
        return iterator_to_array($this);
    }
}
