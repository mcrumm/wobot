<?php

namespace spec\Crummy\Wobot\Listener;

use Crummy\Wobot\Context;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextListenerSpec extends ObjectBehavior
{
    function let(Mainframe $mainframe, Context $context)
    {
        $this->beConstructedWith('/foo/', $mainframe, $context);
    }

    function it_is_a_listener()
    {
        $this->shouldHaveType('Crummy\Wobot\Listener\TextListener');
        $this->shouldBeAnInstanceOf('\Crummy\Wobot\Listener');
    }
}
