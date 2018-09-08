<?php

use RoverChallenge\Plateau;
use RoverChallenge\Position;
use RoverChallenge\Rover;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    public function testPrintPosition() : string
    {
        $roverTest = new Rover(Plateau::create(5, 5), Position::locate(1, 2, 'N'));
        $this->assertEquals('1 2 N', $roverTest->printPosition());
    }

    public function testExplore() : string
    {
        $roverTest = new Rover(Plateau::create(5, 5), Position::locate(1, 2, 'N'));
        $roverTest->explore('MMRMMRMRRM');
        $this->assertEquals('3 4 N', $roverTest->printPosition());
    }
}