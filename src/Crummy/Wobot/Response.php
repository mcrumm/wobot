<?php

namespace Crummy\Wobot;

class Response
{
    private $mainframe;
    private $message;
    private $match;

    /** @var \Crummy\Wobot\Context */
    protected $context;

    /**
     * Constructor.
     * @param Mainframe $mainframe
     * @param Message $message
     * @param $match
     */
    public function __construct(Mainframe $mainframe, Message $message, $match)
    {
        $this->mainframe    = $mainframe;
        $this->message      = $message;
        $this->match        = $match;

        $this->context      = $message->getContext();
    }

    /**
     * Mark the contained message as completed.
     */
    public function finish()
    {
        $this->message->finish();
        return $this;
    }

    /**
     * @return string|false
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Proxy events to the Mainframe.
     * @param $event
     * @param array $arguments
     */
    public function emit($event, array $arguments = [])
    {
        $this->mainframe->emit($event, $arguments);
    }

    /**
     * @param $text
     * @param Context $context
     * @return $this
     */
    public function send($text, Context $context = null)
    {
        $this->mainframe->getAdapter()->send($context ?: $this->context, $text);
        return $this;
    }
}
