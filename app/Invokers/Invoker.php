<?php

namespace App\Invokers;

use App\Commands\Command;

class Invoker
{
    private $command;

    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    public function executeCommand()
    {
        $this->command->execute();
    }
}

