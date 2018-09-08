<?php

namespace RoverChallenge;

use RoverChallenge\ErrorHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class Core extends Command
{
    private $output;

    protected function configure()
    {
        $this->setName("rover:core")
             ->setDescription("Mars Rover Challenge");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $helper = $this->getHelper('question');

        do {
                $question = new Question("Welcome to the Mars Rover Challenge\nPlease enter the upper-right corner of grid (X Y), eg. 5 5\n");

                $coordinates = $helper->ask($input, $output, $question);
        } while (!$plateau = $this->createPlateau($coordinates));

        while (true) {
            do {
                $question = new Question("Please deploy rover to plateau. eg. 1 2 N or 3 3 E\n");

                $position = $helper->ask($input, $output, $question);

            } while (!$rover = $this->deployRover($plateau, $position));

                $question = new Question("Please input command for the rover. eg. MMRMMRMRRM\n");

                $command = $helper->ask($input, $output, $question);

                $rover->explore($command);

                $this->output->writeln($rover->printPosition());

                $question = new ConfirmationQuestion('Do you want to continue? (y/N)', false);

            if (!$helper->ask($input, $output, $question)) {
                break;
            }
        }
    }

    private function createPlateau($coordinates)
    {
        [$x, $y] = explode(" ", $coordinates);

        try {
            $plateau = Plateau::create($x, $y);

            return $plateau;
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());

            return false;
        }
    }

    private function deployRover(Plateau $plateau, $position)
    {
        $check = explode(" ", $position);
        if(count($check) !== 3 || !in_array(strtoupper($check[2]), Direction::$direction)){
            $this->output->writeln(ErrorHandler::invalidDirection);
            return false;
        }

        [$x, $y, $o] = explode(" ", $position);

        try {
            $position = Position::locate($x, $y, $o);
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());

            return false;
        }

        try {
            $rover = $plateau->deploy($position);

            return $rover;
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());

            return false;
        }

    }
}