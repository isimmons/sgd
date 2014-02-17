<?php

use Isimmons\Sgd\Console\RepoAddCommand;
use Symfony\Component\Console\Tester\CommandTester;

class RepoAddCommandTest extends TestCase {

    public function setUp()
    {
            $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testArguments()
    {
        $this->mock->shouldReceive('add')
            ->once()
            ->with('repo', 'testfile')
            ->andReturn(true);

        $command = new RepoAddCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'file' => 'testfile']);
        
        $this->assertEquals('Files successfully added. Ready for commit.', $tester->getDisplay());
    }

    public function testOptionalDefaultArguments()
    {
        $this->mock->shouldReceive('add')
            ->once()
            ->with('repo', '.')
            ->andReturn(true);

        $command = new RepoAddCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('Files successfully added. Ready for commit.', $tester->getDisplay());
    }
}
