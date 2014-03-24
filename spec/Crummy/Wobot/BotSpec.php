<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BotSpec extends ObjectBehavior
{
    function it_is_a_bot()
    {
        $this->shouldHaveType('Crummy\Wobot\Bot');
    }

    function it_connects_to_the_mainframe(Mainframe $mainframe)
    {
        $this->connect($mainframe)->shouldBe(null);
    }

    function it_is_invokable(Response $response)
    {
        $this->__invoke($response)->shouldBe(null);
    }
}
