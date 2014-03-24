<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Bot;
use Crummy\Wobot\Context;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListenerSpec extends ObjectBehavior
{
    function let(Mainframe $mainframe, Context $context)
    {
        $this->beConstructedWith($mainframe, $context);
    }

    function it_is_a_listener()
    {
        $this->shouldHaveType('Crummy\Wobot\Listener');
    }

    function it_checks_the_matcher_against_the_message_when_invoked(Context $context, Message $message, Bot $bot)
    {
        $matcher = function() { return true; };

        $context->offsetGet('callback')->willReturn($bot);
        $context->offsetGet('matcher')->willReturn($matcher);

        $this($message);
    }
}
