<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class FizzBuzzCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:fizzbuzz')
            ->setDescription('Runs the FizzBuzz service over a given range')
            ->setHelp('todo');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $questionValidator = function ($answer) {
            if (!ctype_digit(ltrim($answer, '-'))) {
                throw new \RuntimeException(
                    'The range value must be an integer'
                );
            }
            return (int) $answer;
        };

        $rangeStartQuestion = new Question('What number do you want to FizzBuzz from?', 1);
        $rangeStartQuestion->setValidator($questionValidator)->setMaxAttempts(2);

        $rangeEndQuestion = new Question('What number do you want to FizzBuzz to?', 20);
        $rangeEndQuestion->setValidator($questionValidator)->setMaxAttempts(2);

        $rangeStart = $helper->ask($input, $output, $rangeStartQuestion);
        $rangeEnd = $helper->ask($input, $output, $rangeEndQuestion);

        $fizzBuzzService = $this->getContainer()->get('app.fizz_buzz_service');

        $output->writeln(
            $fizzBuzzService->getFizzBuzzString($rangeStart, $rangeEnd)
        );

    }
}
