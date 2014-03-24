<?php

namespace Crummy\Wobot;

class Listener
{
    private $mainframe;
    private $context;

    /**
     * Constructor.
     * @param Mainframe $mainframe
     * @param Context $context
     */
    public function __construct(Mainframe $mainframe, Context $context)
    {
        $this->mainframe    = $mainframe;
        $this->context      = $context;
    }

    /**
     * Sends a matching Message to this Listener's callback.
     * @param Message $message
     */
    public function __invoke(Message $message)
    {
        $match = $this->context['matcher']($message);

        if (false !== $match) {
            $this->context['callback'](new Response($this->mainframe, $message, $match));
        }
    }
}
