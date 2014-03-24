<?php

namespace Crummy\Wobot\Adapter;

use Crummy\Wobot\Adapter as BaseAdapter;
use Crummy\Wobot\Context;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;
use Pecan\Shell;
use React\EventLoop\LoopInterface;
use Monolog\Logger;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;

class ShellAdapter extends BaseAdapter
{
    private $shell;

    /**
     * @param Shell $shell
     * @param Mainframe $mainframe
     */
    public function __construct(Shell $shell, Mainframe $mainframe)
    {
        parent::__construct($mainframe);

        $this->shell = $shell;
    }

    /**
     * @param Context $context
     * @param $text
     */
    public function send(Context $context, $text)
    {
        $this->shell->emit('output', [ sprintf('<comment>%s</comment>', $text) ]);
    }

    /**
     * Starts the shell and runs this adapter.
     *
     * @param LoopInterface $loop
     */
    public function start(LoopInterface $loop)
    {
        $this->shell->start($loop);

        $this->run();
    }

    /**
     * Starts the shell.
     * Conditionally pushes a ConsoleHandler for logging if it and a Monolog Logger are available.
     */
    public function run()
    {
        if (class_exists('\\Symfony\\Bridge\\Monolog\\Handler\\ConsoleHandler') && class_exists('\\Monolog\\Logger')) {
            $this->shell->on('running', function (Shell $shell) {
                $logger = $this->mainframe->getLogger();
                if ($logger instanceof Logger) {
                    $logger->pushHandler(new ConsoleHandler($shell->getOutput()));
                }
            });
        }

        $this->shell->on('error', function ($error) {
            $this->mainframe->emit('error', [ $error ]);
        });

        $this->mainframe->on('shutdown', function() {
           $this->shell->close();
        });

        $this->shell->on('exit', function ($exitCode, Shell $shell) {
            $signOff = PHP_EOL . $shell->getApplication()->getName() . ', out.';
            $shell->write($signOff);
        });

        $this->shell->on('running', function () {
            $this->emit('connected');
        });
    }

}
