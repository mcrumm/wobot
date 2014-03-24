<?php

namespace spec\Crummy\Wobot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContextSpec extends ObjectBehavior
{
    function it_is_a_container()
    {
        $this->shouldHaveType('Crummy\Wobot\Context');
        $this->shouldBeAnInstanceOf('\Pimple');
    }
}
