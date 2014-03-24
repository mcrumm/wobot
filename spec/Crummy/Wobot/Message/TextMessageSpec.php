<?php

namespace spec\Crummy\Wobot\Message;

use Crummy\Wobot\Context;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextMessageSpec extends ObjectBehavior
{
    function let(Context $context)
    {
        $this->beConstructedWith($context, 'hello world');
    }

    function it_is_a_message()
    {
        $this->shouldHaveType('Crummy\Wobot\Message\TextMessage');
        $this->shouldBeAnInstanceOf('\Crummy\Wobot\Message');
    }

    function it_can_match_to_a_regex()
    {
        $this->match('/hello/')->shouldBe('hello');
    }

    function it_returns_false_for_a_non_match()
    {
        $this->match('/foo/')->shouldBe(false);
    }
}
