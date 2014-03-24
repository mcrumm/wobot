<?php

namespace Crummy\Wobot\Listener;

use Crummy\Wobot\Context;
use Crummy\Wobot\Listener;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;

class TextListener extends Listener
{
    /**
     * @param string $regex
     * @param Mainframe $mainframe
     * @param Context $context
     */
    public function __construct($regex, Mainframe $mainframe, Context $context)
    {
        $context['matcher'] = $context->protect(function (Message $message) use ($regex) {
            return $message instanceof Message\TextMessage ? $message->match($regex) : false;
        });

        parent::__construct($mainframe, $context);
    }
}
