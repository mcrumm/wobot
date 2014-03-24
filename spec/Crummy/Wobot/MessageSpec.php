<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Context;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function let(Context $c)
    {
        $this->beConstructedWith($c, false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Wobot\Message');
    }

    function it_is_not_finished_when_initialized()
    {
        $this->shouldNotBeFinished();
    }

    function it_can_be_marked_finished()
    {
        $this->finish();
        $this->shouldBeFinished();
    }

    function it_shares_context(Context $c)
    {
        $this->getContext()->shouldReturn($c);
    }
}
