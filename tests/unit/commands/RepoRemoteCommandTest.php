<?php

use Isimmons\Sgd\Console\RepoRemoteCommand;
use Symfony\Component\Console\Tester\CommandTester;


class RepoRemoteCommandTest extends TestCase {

    public function setUp()
    {        
        $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItAddsRemoteToRepo()
    {
        $this->mock->shouldReceive('remote')
            ->once()
            ->with('repo', 'add', 'origin', 'git@github.com:isimmons/foo.git')
            ->andReturn(true);

        $command = new RepoRemoteCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'action' => 'add', 'remote' => 'origin', 'url' => 'git@github.com:isimmons/foo.git']);
        
        $this->assertEquals('origin git@github.com:isimmons/foo.git added to repo', $tester->getDisplay());
    }

    public function testItRemovesRemoteFromRepo()
    {
        $this->mock->shouldReceive('remote')
            ->once()
            ->with('repo', 'rm', 'origin', 'git@github.com:isimmons/foo.git')
            ->andReturn(true);

        $command = new RepoRemoteCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'action' => 'rm', 'remote' => 'origin', 'url' => 'git@github.com:isimmons/foo.git']);
        
        $this->assertEquals('origin git@github.com:isimmons/foo.git removed from repo', $tester->getDisplay());
    }

    public function testRemoteUsesOptionalArguments()
    {
        $this->mock->shouldReceive('remote')
            ->once()
            ->with('repo', 'add', 'origin', 'git@github.com:isimmons/foo.git')
            ->andReturn(true);

        $command = new RepoRemoteCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'action' => 'add', 'url' => 'git@github.com:isimmons/foo.git']);
        
        $this->assertEquals('origin git@github.com:isimmons/foo.git added to repo', $tester->getDisplay());
    }

    public function testItFailsToAddRemoteToRepo()
    {
        $this->mock->shouldReceive('remote')
            ->once()
            ->with('repo', 'add', 'origin', 'git@github.com:isimmons/foo.git')
            ->andReturn(false);

        $command = new RepoRemoteCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'action' => 'add', 'remote' => 'origin', 'url' => 'git@github.com:isimmons/foo.git']);
        
        $this->assertEquals(
            "Fail: Unable to add/remove remote 'origin' @url 'git@github.com:isimmons/foo.git' to repo 'repo'",
                $tester->getDisplay());
    }

}
