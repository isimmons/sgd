<?php

use Isimmons\Sgd\Console\RepoMergeCommand;
use Symfony\Component\Console\Tester\CommandTester;


class RepoMergeCommandTest extends TestCase {

    public function setUp()
    {
        //$this->markTestSkipped('Test skipped. Not implimented yet');
        $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testAllArguments()
    {
        $this->mock->shouldReceive('merge')
            ->once()
            ->with('repo', 'origin', true)
            ->andReturn(true);

        $command = new RepoMergeCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'remote' => 'origin', 'commit' => 'true']);
        
        $this->assertEquals('merge repo -->>{}<<-- origin Success.', $tester->getDisplay());
    }

     public function testOptionalArguments()
    {
        $this->mock->shouldReceive('merge')
            ->once()
            ->with('repo', 'origin', false)
            ->andReturn(true);

        $command = new RepoMergeCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'remote' => 'origin']);
        
        $this->assertEquals('merge repo -->>{}<<-- origin Success.', $tester->getDisplay());
    }

}
