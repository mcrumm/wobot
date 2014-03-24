<?php

namespace Crummy\Bots;

use Crummy\Wobot\Bot;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Response;

/**
 * This bot tells time.
 */
class TimeBot extends Bot
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(Response $response)
    {
        $date   = new \DateTime();
        $match  = $response->getMatch();

        // Get the date format, if provided.
        $format = isset($match[1]) && !empty($match[1]) ? ltrim($match[1]) : false;

        // If a format was provided, format the date accordingly.  Otherwise, send the timestamp.
        $text   = $format ? $date->format($format) : $date->getTimestamp();

        $response->send($text)->finish();
    }

    /**
     * {@inheritDoc}
     */
    public function connect(Mainframe $mainframe)
    {
        $mainframe->hear('/^time(?:\:)?(.*)$/', $this);
    }
}
