<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Context;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    function let(Mainframe $mainframe, Message $message)
    {
        $this->beConstructedWith($mainframe, $message, true);
    }

    function it_is_a_response()
    {
        $this->shouldHaveType('Crummy\Wobot\Response');
    }

    function it_can_mark_its_message_finished(Message $message)
    {
        $message->getContext()->shouldBeCalled();
        $message->finish()->shouldBeCalled();
        $this->finish()->shouldReturn($this);
    }

    function it_shares_context(Message $message, Context $c)
    {
        $message->getContext()->willReturn($c);
        $this->getContext()->shouldReturn($c);
    }

    function it_shares_match()
    {
        $this->getMatch()->shouldReturn(true);
    }
}
