<?php

namespace Crummy\Bots;

use Crummy\Wobot\Bot;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Response;

/**
 * This bot tells time
 */
class TimeBot extends Bot
{
    public function __invoke(Response $response)
    {
        $date   = new \DateTime();
        $match  = $response->getMatch();

        $response->send(print_r($match, true));

        if (isset($match[1]) && !empty($match[1])) {
            return $response->send($date->format($match[1]));
        }

        return $response->send($date->getTimestamp());
    }

    public function connect(Mainframe $mainframe)
    {
        $mainframe->hear('/^time(?:\:?) (.*)$/', $this);
    }
}
