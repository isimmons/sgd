<?php

use Isimmons\Sgd\Console\RepoPushCommand;
use Symfony\Component\Console\Tester\CommandTester;


class RepoPushCommandTest extends TestCase {

    public function setUp()
    {        
        $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testAllArguments()
    {
        $this->mock->shouldReceive('push')
            ->once()
            ->with('repo', 'origin', 'master')
            ->andReturn(true);

        $command = new RepoPushCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'remote' => 'origin', 'branch' => 'master']);
        
        $this->assertEquals('Files successfully pushed to remote repository.', $tester->getDisplay());
    }

    public function testOptionalDefaultArguments()
    {
        $this->mock->shouldReceive('push')
            ->once()
            ->with('repo', 'origin', 'master')
            ->andReturn(true);

        $command = new RepoPushCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('Files successfully pushed to remote repository.', $tester->getDisplay());
    }
}