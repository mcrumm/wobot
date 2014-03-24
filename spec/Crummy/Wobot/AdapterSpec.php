<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdapterSpec extends ObjectBehavior
{
    function let(Mainframe $mainframe)
    {
        $this->beConstructedWith($mainframe);
    }

    function it_is_an_event_emitter()
    {
        $this->shouldHaveType('Crummy\Wobot\Adapter');
        $this->shouldBeAnInstanceOf('\Evenement\EventEmitter');
    }

    function it_can_receive_a_message(Message $message)
    {
        $this->receive($message)->shouldReturn($this);
    }

    function it_can_run()
    {
        $this->run()->shouldBe(null);
    }
}
