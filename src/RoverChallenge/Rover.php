<?php

namespace RoverChallenge;

use RoverChallenge\ErrorHandler;

class Rover
{
    private $plateau;

    private $position;

    public function __construct(Plateau $plateau, Position $position)
    {
        if (!$position->deploySuccess($plateau)) {
            return print ErrorHandler::invalidPlateau;
        }

        if (!Direction::isValid($position->getDirection())) {
            return print ErrorHandler::invalidDirection;
        }

        $this->plateau = $plateau;
        $this->position = $position;
    }

    public function printPosition()
    {
        return $this->position->getX() . ' ' . $this->position->getY() . ' ' . $this->position->getDirection();
    }

    public function explore($input)
    {
        $commands = str_split($input);

        foreach ($commands as $command) {
            $this->control($command);
        }
    }

    private function control($command)
    {
        switch (strtoupper($command)) {
            case 'L':
                $this->position->TurnLeft();
                break;

            case 'R':
                $this->position->TurnRight();
                break;

            case 'M':
                $this->position->move($this->plateau);
                break;
        }
    }
}