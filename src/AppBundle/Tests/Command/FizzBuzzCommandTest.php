<?php

namespace AppBundle\Tests\Command;

use AppBundle\Command\FizzBuzzCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FizzBuzzCommandTest extends KernelTestCase
{

    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new FizzBuzzCommand());

        $command = $application->find('app:fizzbuzz');

        $commandTester = new CommandTester($command);

        // need to set the answers to the range questions for tests
        $helper = $command->getHelper('question');
        $helper->setInputStream($this->getInputStream("1\n20\n"));

        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('1 2 fizz 4 buzz fizz 7 8 fizz buzz 11 fizz 13 14 fizzbuzz 16 17 fizz 19 buzz', $output);

    }

    /**
     * The Symfony recommended way of handling the faked input stream in 2.8. Symfony 3 has a much improved setter system
     *
     * @param $input
     * @return resource
     */
    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
