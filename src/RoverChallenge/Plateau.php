<?php

namespace RoverChallenge;

use RoverChallenge\ErrorHandler;

class Plateau
{
    private static $instance;

    private $x;

    private $y;

    public function __construct($x, $y)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
    }

    public static function create($x, $y)
    {
        if (is_numeric($x) && is_numeric($y) && $x > 0 && $y > 0) {
            return new self($x, $y);
        } else {
            print ErrorHandler::invalidPlateau;
        }
    }

    public function deploy(Position $pos)
    {
        if (!$pos->deploySuccess($this)) {
             return print ErrorHandler::invalidPlateau;
        }
        return new Rover($this, $pos);
    }

    public function getX() : int
    {
        return $this->x;
    }

    public function getY() : int
    {
        return $this->y;
    }

}