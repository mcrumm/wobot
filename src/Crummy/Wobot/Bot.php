<?php

namespace Crummy\Wobot;

class Bot
{
    /**
     * Invokes the Bot callback.  Extend this in your Bot.
     * @param Response $response
     */
    public function __invoke(Response $response) {}

    /**
     * Connects this Bot to the mainframe. Extend this in your Bot.
     * @param Mainframe $mainframe
     */
    public function connect(Mainframe $mainframe) {}
}
