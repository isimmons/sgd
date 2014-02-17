<?php

use Isimmons\Sgd\Git;
use Isimmons\Sgd\Console\RepoMakeCommand;
use Symfony\Component\Console\Tester\CommandTester;

class RepoMakeCommandTest extends TestCase {

    public function setUp()
    {
            $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testCreatesRepo()
    {
        $this->mock->shouldReceive('make')
            ->once()
            ->with('repo')
            ->andReturn(true);

        $command = new RepoMakeCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('New repository repo created.', $tester->getDisplay());
    }

    public function testFailsToCreateRepo()
    {
        $this->mock->shouldReceive('make')
            ->once()
            ->with('repo')
            ->andReturn(false);

        $command = new RepoMakeCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('Failed to create repository repo.', $tester->getDisplay());
    }

}