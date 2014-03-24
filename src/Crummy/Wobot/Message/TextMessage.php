<?php

namespace Crummy\Wobot\Message;

use Crummy\Wobot\Context;
use Crummy\Wobot\Message;

class TextMessage extends Message
{
    public $text;

    /**
     * @param Context $context
     * @param string $text
     */
    public function __construct(Context $context, $text)
    {
        $this->text = $text;

        parent::__construct($context);
    }

    /**
     * Attempts to match
     * @param $regex
     * @return string|boolean The first match, or false if none found.
     */
    public function match($regex)
    {
        $matches    = [];
        $found      = preg_match($regex, $this->text, $matches);

        return $found > 0 ? $matches : false;
    }
}
