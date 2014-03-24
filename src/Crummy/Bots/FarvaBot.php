<?php

namespace Crummy\Bots;

use Crummy\Wobot\Bot;
use Crummy\Wobot\Mainframe;
use Crummy\Wobot\Response;

class FarvaBot extends Bot
{
    protected $taunts = [
        'I\'m not even gonna dignify myself with a response to that.',
        'Sing it again, rookie biatch!',
        'Where\'d you learn that, Cheech? Drug school?',
        'Are you done?',
        'Say car ramrod'
    ];

    protected $sayings = [
        'meow'  => 'Hell I can say "meow". I can say "moo". For twenty bucks, I\'ll call the guy a chickenfucker!',
        'punch' => 'You wanna go punch for punch?',
        'union' => 'Cap\'n, You know I\'m not a pro union guy.',
        'quote' => [
            'You burger punk sonofabitch!',
            'I don\'t want a large Farva...I want a goddamn litre o\' cola!',
            'You look like the President and CEO of Levi-Strauss!',
            'Say car ramrod'
        ],
        'shenanigans' => [
            'Did someone say Shenanigans?',
            'Are you guys talking about Shenanigans?',
            'Say car ramrod'
        ],
        'car ramrod' => [
            'License and registration, chickenfucker! Ba-COCK!!!',
        ]
    ];

    /**
     * {@inheritDoc}
     */
    public function connect(Mainframe $mainframe)
    {
        $mainframe->hear('/^farva(?:\:)?(.*)/', $this);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(Response $response)
    {
        $match      = $response->getMatch();
        $trigger    = isset($match[1]) ? ltrim($match[1]) : null;

        if (!array_key_exists($trigger, $this->sayings)) {
            $text = $this->getRandomValue($this->taunts);
        } else {
            if (is_array($this->sayings[$trigger])) {
                $text = $this->getRandomValue($this->sayings[$trigger]);
            } else {
                $text = $this->sayings[$trigger];
            }
        }

        $response->send($text)->finish();
    }

    /**
     * @param array $array
     * @return mixed
     */
    protected function getRandomValue(array $array)
    {
        return $array[array_rand($array)];
    }
}
