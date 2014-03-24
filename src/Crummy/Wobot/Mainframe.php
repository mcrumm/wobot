<?php

namespace Crummy\Wobot;

use Crummy\Wobot\Listener\TextListener;
use Evenement\EventEmitter;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Mainframe extends \Pimple
{
    /** @var \Evenement\EventEmitter */
    protected $events;

    /** @var \Crummy\Wobot\Adapter */
    protected $adapter;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    /** @var \Closure[] */
    private $listeners = [];

    /**
     * Constructor.
     * @param string $name
     * @param LoggerInterface $logger
     */
    public function __construct($name = 'wobot', LoggerInterface $logger = null)
    {
        parent::__construct(['name' => $name]);

        $this->setLogger($logger ?: new NullLogger());

        $this->events = new EventEmitter();

        $this->on('error', [ $this, 'handleError']);
    }

    /**
     * Identify this mainframe.
     *
     * @return string
     */
    public function uname()
    {
        return $this['name'];
    }

    /**
     * Adds a Listener with the specified regex.
     * @param string $regex
     * @param Bot|\Closure $callback
     * @return $this
     */
    public function hear($regex, callable $callback)
    {
        $context                = new Context();
        $context['callback']    = $context->protect($callback);
        $this->listeners[]      = new TextListener($regex, $this, $context);
        return $this;
    }

    /**
     * Helper method to simplify event calling.
     * @param $event
     * @param callable $listener
     */
    public function on($event, callable $listener)
    {
        $this->events->on($event, $listener);
    }

    /**
     * Helper method to simplify event calling.
     * @param $event
     * @param array $arguments
     */
    public function emit($event, array $arguments = [])
    {
        $this->events->emit($event, $arguments);
    }

    /**
     * @param Adapter $adapter
     * @return $this
     */
    public function connect(Adapter $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Receives a Message.
     * @param Message $message
     * @return void
     */
    public function receive(Message $message)
    {
        foreach ($this->listeners as $listener) {
            try {
                $listener($message);
                if ($message->isFinished()) {
                    break;
                }
            }
            catch (\Exception $error) {
                $this->emit('error', [ $error ]);
            }
        }
    }

    /**
     * Starts the adapter's event loop.
     * @throws \RuntimeException
     */
    public function run()
    {
        if (!$this->adapter) {
            throw new \LogicException('Please connect an Adapter before starting the Mainframe.');
        }

        $this->emit('running');
        $this->adapter->run();
    }

    /**
     * Loads the Bot into this Mainframe.
     * @param Bot $bot
     * @return $this
     */
    public function loadBot(Bot $bot)
    {
        $bot->connect($this);
        return $this;
    }

    /**
     * Emits the shutdown event.
     * @param int $errorCode
     */
    public function shutdown($errorCode = 0)
    {
        $this->logger->info('Shutting down.', [ 'code' => $errorCode ]);
        $this->emit('shutdown', [ $this, $errorCode ]);
    }

    /**
     * Logs the error and shuts down the Mainframe.
     * @param string|\Exception $error
     */
    public function handleError($error)
    {
        $this->logger->error($error);
        $code = $error instanceof \Exception ? $error->getCode() : -1;
        $code = 0 !== $code ? $code : -1;
        $this->shutdown($code);
    }

    /**
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
