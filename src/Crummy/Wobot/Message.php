<?php

namespace Crummy\Wobot;

class Message
{
    protected $context;
    protected $done;

    /**
     * Constructor.
     * @param Context $context
     * @param boolean $done
     */
    public function __construct(Context $context, $done = false)
    {
        $this->context  = $context;
        $this->done     = (boolean)$done;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Checks whether or not the message has been marked finished.
     * @return boolean
     */
    public function isFinished()
    {
        return $this->done;
    }

    /**
     * Mark the message as finished.  No other listeners will be called on this Message.
     * @return $this
     */
    public function finish()
    {
        $this->done = true;
        return $this;
    }
}
