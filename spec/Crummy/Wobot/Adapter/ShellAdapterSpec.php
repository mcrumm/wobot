<?php

namespace spec\Crummy\Wobot\Adapter;

use Pecan\Shell;
use Crummy\Wobot\Context;
use Crummy\Wobot\Mainframe;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use React\EventLoop\LoopInterface;

class ShellAdapterSpec extends ObjectBehavior
{
    function let(Shell $shell, Mainframe $mainframe)
    {
        $this->beConstructedWith($shell, $mainframe);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Wobot\Adapter\ShellAdapter');
        $this->shouldBeAnInstanceOf('\Crummy\Wobot\Adapter');
    }

    function it_starts_the_shell(Shell $shell, LoopInterface $loop)
    {
        $shell->start($loop)->shouldBeCalled();
        $this->start($loop);
    }

    function it_sends_a_message_through_the_shell(Shell $shell)
    {
        $text = 'Hello World!';
        $shell->emit('output', [ $text ])->shouldBeCalled();

        $this->send(new Context(), $text);
    }
}