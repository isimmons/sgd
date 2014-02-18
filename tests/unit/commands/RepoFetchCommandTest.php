<?php

use Isimmons\Sgd\Console\RepoFetchCommand;
use Symfony\Component\Console\Tester\CommandTester;


class RepoFetchCommandTest extends TestCase {

    public function setUp()
    {
        $this->markTestSkipped('Test skipped. Not implimented yet');
        $this->mock = Mockery::mock('Isimmons\Sgd\Git');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testAllArguments()
    {
        $this->mock->shouldReceive('fetch')
            ->once()
            ->with('repo', 'origin')
            ->andReturn(true);

        $command = new RepoFetchCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'remote' => 'origin']);
        
        $this->assertEquals('repo <<-- origin Success.', $tester->getDisplay());
    }

}
