<?php

namespace RoverChallenge;

use RoverChallenge\ErrorHandler;

class Position
{
    private $x;

    private $y;

    private $direction;

    public function __construct($x, $y, $direction)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
        $this->direction = strtoupper($direction);
    }

    public static function locate($x, $y, $direction)
    {
        if (is_numeric($x) && is_numeric($y) && Direction::isValid($direction)) {
            return new self($x, $y, strtoupper($direction));
        } else {
            return print ErrorHandler::invalidPosition;
        }
    }

    public function deploySuccess(Plateau $plateau)
    {
        return $this->getX() >= 0
            && $this->getX() <= $plateau->getX()
            && $this->getY() >= 0
            && $this->getY() <= $plateau->getY();
    }

    public function getX() : int
    {
        return $this->x;
    }

    public function getY() : int
    {
        return $this->y;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function TurnLeft()
    {
        $this->direction = Direction::TurnLeft($this->direction);
    }

    public function TurnRight()
    {
        $this->direction = Direction::TurnRight($this->direction);
    }

    public function move(Plateau $plateau)
    {
        switch (strtoupper($this->direction)) {
            case 'N':
                $this->forward($this->y, 1, $plateau->getY());
                break;

            case 'S':
                $this->forward($this->y, -1, $plateau->getY());
                break;

            case 'W':
                $this->forward($this->x, -1, $plateau->getX());
                break;

            case 'E':
                $this->forward($this->x, 1, $plateau->getX());
                break;
        }
    }

    private function forward(&$point, $shift, $max)
    {
        $point += $shift;

        if ($point < 0) {
            $point = 0;
        }

        if ($point > $max) {
            $point = $max;
        }
    }
}