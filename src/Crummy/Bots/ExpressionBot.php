<?php

namespace Crummy\Bots;

use Crummy\Wobot\Bot;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Response;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionBot extends Bot
{
    /** @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage */
    protected $language;

    /**
     * Constructor.
     * @param ExpressionLanguage $language
     */
    function __construct(ExpressionLanguage $language = null)
    {
        $this->language = $language ?: new ExpressionLanguage();
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(Response $response)
    {
        $match      = $response->getMatch();
        $expression = isset($match[1]) ? ltrim($match[1]) : null;
        $text       = $this->language->evaluate($expression);

        $response->send($text)->finish();
    }

    /**
     * {@inheritDoc}
     */
    public function connect(Mainframe $mainframe)
    {
        $mainframe->hear('/^math(?:\:)?(.*)$/', $this);
    }

}
