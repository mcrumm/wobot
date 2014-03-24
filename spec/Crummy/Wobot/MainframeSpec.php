<?php

namespace spec\Crummy\Wobot;

use Crummy\Wobot\Adapter;
use Crummy\Wobot\Bot;
use Crummy\Wobot\Context;
use Crummy\Wobot\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class MainframeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testbot');
    }

    function it_is_a_container()
    {
        $this->shouldHaveType('Crummy\Wobot\Mainframe');
        $this->shouldBeAnInstanceOf('\Pimple');
    }

    function it_connects_an_adapter(Adapter $adapter)
    {
        $this->connect($adapter)->shouldReturn($this);
    }

    function it_shares_adapter(Adapter $adapter)
    {
        $this->connect($adapter)->getAdapter()->shouldReturn($adapter);
    }

    function it_may_have_a_logger(LoggerInterface $logger)
    {
        $this->setLogger($logger)->shouldReturn($this);
    }

    function it_can_receive_a_message(Message $message)
    {
        $this->receive($message)->shouldBe(null);
    }

    function it_has_a_helper_for_on()
    {
        $this->on('event.name', function(Context $context) {})->shouldBe(null);
    }

    function it_has_a_helper_for_emit(Context $context)
    {
        $this->emit('event.name', [ $context ])->shouldBe(null);
    }

    function it_cannot_run_without_an_adapter()
    {
        $this->shouldThrow('\LogicException')->during('run');
    }

    function it_runs_with_an_adapter(Adapter $adapter)
    {
        $this->connect($adapter);

        $adapter->run()->shouldBeCalled();

        $this->run();
    }

    function it_loads_a_bot(Bot $bot)
    {
        $bot->connect($this)->shouldBeCalled();
        $this->loadBot($bot)->shouldReturn($this);
    }

    function it_lets_a_bot_hear(Bot $bot)
    {
        $this->hear('/shenanigans/', $bot)->shouldReturn($this);
    }
}
