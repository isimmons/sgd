<?php

use Isimmons\Sgd\Console\RepoValidateCommand;
use Symfony\Component\Console\Tester\CommandTester;

class RepoValidateCommandTest extends TestCase {

     public function setUp()
    {
            $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItDetectsValidRepo()
    {
        $this->mock->shouldReceive('validate')
            ->once()
            ->with('repo')
            ->andReturn(true);

        $command = new RepoValidateCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('repo is a valid repository.', $tester->getDisplay());        
    }

    public function testItDetectsInvalidRepo()
    {
        $this->mock->shouldReceive('validate')
            ->once()
            ->with('repo')
            ->andReturn(false);

        $command = new RepoValidateCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo']);
        
        $this->assertEquals('repo NOT a valid repository.', $tester->getDisplay());        
    }

}