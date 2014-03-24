<?php

namespace Crummy\Wobot;

use Evenement\EventEmitter;
use Psr\Log\LoggerInterface;

class Adapter extends EventEmitter
{
    /** @var \Crummy\Wobot\Mainframe */
    protected $mainframe;

    /**
     * @param Mainframe $mainframe
     */
    public function __construct(Mainframe $mainframe)
    {
        $this->mainframe = $mainframe->connect($this);
    }

    /**
     * Called by the Mainframe to start the Adapter. Extend this in your Adapter.
     */
    public function run()
    {
    }

    /**
     * Sends a message.  Extend this in your Adapter.
     * @param Context $context
     * @param $text
     */
    public function send(Context $context, $text)
    {
    }

    /**
     * Passes a received Message to the Mainframe.
     * @param Message $message
     * @return $this Provides a fluent interface so message receiving can be chainable.
     */
    public function receive(Message $message)
    {
        $this->mainframe->receive($message);
        return $this;
    }

    /**
     * Proxy method to load Bots into the Mainframe.
     * @param Bot $bot
     * @return $this
     */
    public function loadBot(Bot $bot)
    {
        $this->mainframe->loadBot($bot);
        return $this;
    }

    /**
     * Proxy method to set the LoggerInterface on the Mainframe.
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->mainframe->setLogger($logger);
        return $this;
    }

    /**
     * Gets the LoggerInterface from the Mainframe.
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->mainframe->getLogger();
    }

}
