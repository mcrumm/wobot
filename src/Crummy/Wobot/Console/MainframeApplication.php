<?php

namespace Crummy\Wobot\Console;

use Crummy\Wobot\Mainframe;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

class MainframeApplication extends BaseApplication
{
    private $command;

    /**
     * Constructor.
     *
     * @param Mainframe $mainframe
     * @param string $version
     */
    public function __construct(Mainframe $mainframe, $version = 'UNKNOWN')
    {
        $this->command = new WobotCommand($mainframe);

        parent::__construct($mainframe->uname(), $version);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return $this->command->getName();
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return array An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = [ $this->command ];

        return $defaultCommands;
    }

    /**
     * Overridden so that the application doesn't expect the command
     * name to be the first argument.
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
 