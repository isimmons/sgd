<?php

use Isimmons\Sgd\Console\RepoStatusCommand;
use Symfony\Component\Console\Tester\CommandTester;

class RepoStatusCommandTest extends TestCase {

    public function setUp()
    {
            $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItChecksGitStatus()
    {
        $this->mock->shouldReceive('status')
            ->once()
            ->with('repo')
            ->andReturn('status');

        $command = new RepoStatusCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('status', $tester->getDisplay());
    }

    public function testItChecksGitStatusAndFails()
    {
        $this->mock->shouldReceive('status')
            ->once()
            ->with('repo')
            ->andReturn(false);

        $command = new RepoStatusCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('Failed to run git status on repo.', $tester->getDisplay());
    }

}
