<?php

namespace Crummy\Wobot\Console;

use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message\TextMessage;
use Crummy\Wobot\Context;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WobotCommand extends BaseCommand
{
    /** @var \Crummy\Wobot\Mainframe */
    protected $mainframe;

    /**
     * Constructor.
     *
     * @param Mainframe $mainframe
     */
    public function __construct(Mainframe $mainframe)
    {
        parent::__construct($mainframe->uname());

        $this->mainframe = $mainframe;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setDefinition([
           new InputArgument('command', InputArgument::OPTIONAL|InputArgument::IS_ARRAY)
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = implode(' ', $input->getArgument('command'));

        $message = new TextMessage(new Context([]), $command);
        $this->mainframe->receive($message);
    }
}
