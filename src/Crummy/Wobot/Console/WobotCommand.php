<?php

namespace Crummy\Wobot\Console;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getName());

        /*
        $message = new Message\TextMessage(new Context([]), $command);
        $this->mainframe->receive($message);
        */
    }
}
