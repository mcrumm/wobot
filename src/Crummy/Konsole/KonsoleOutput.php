<?php

namespace Crummy\Konsole;

use Evenement\EventEmitterTrait;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\Output;

class KonsoleOutput extends Output
{
    public $stream;

    /**
     * Constructor.
     *
     * @param LoopInterface $loop
     * @param bool|int $verbosity
     * @param bool $decorated
     * @param OutputFormatterInterface $formatter
     */
    public function __construct(LoopInterface $loop, $verbosity = self::VERBOSITY_NORMAL, $decorated = true, OutputFormatterInterface $formatter = null)
    {
        $outputStream = 'php://stdout';
        if (!$this->hasStdoutSupport()) {
            $outputStream = 'php://output';
        }

        $this->stream = new Stream(fopen($outputStream, 'w'), $loop);

        parent::__construct($verbosity, $decorated, $formatter);
    }

    /**
     * Closes the output stream.
     *
     * @param null $data
     */
    public function end($data = null)
    {
        $this->stream->end($data);
    }

    /**
     * Writes a message to the output.
     *
     * @param string $message A message to write to the output
     * @param boolean $newline Whether to add a newline or not
     */
    protected function doWrite($message, $newline)
    {
        $this->stream->write($newline ? $message . PHP_EOL : $message);
    }

    /**
     * Returns true if current environment supports writing console output to
     * STDOUT.
     *
     * IBM iSeries (OS400) exhibits character-encoding issues when writing to
     * STDOUT and doesn't properly convert ASCII to EBCDIC, resulting in garbage
     * output.
     *
     * @return boolean
     */
    protected function hasStdoutSupport()
    {
        return ('OS400' != php_uname('s'));
    }
}
