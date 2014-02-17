<?php

use Isimmons\Sgd\Console\RepoCommitCommand;
use Symfony\Component\Console\Tester\CommandTester;

class RepoCommitCommandTest extends TestCase {

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
        $this->mock->shouldReceive('commit')
            ->once()
            ->with('repo', 'test message')
            ->andReturn(true);

        $command = new RepoCommitCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'message' => 'test message']);
        
        $this->assertEquals('Files successfully commited. Ready to push.', $tester->getDisplay());
    }

    public function testOptionalDefaultArguments()
    {
        $this->mock->shouldReceive('commit')
            ->once()
            ->with('repo', 'New Post')
            ->andReturn(true);

        $command = new RepoCommitCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('Files successfully commited. Ready to push.', $tester->getDisplay());
    }
}