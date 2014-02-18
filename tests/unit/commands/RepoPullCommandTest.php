<?php

use Isimmons\Sgd\Console\RepoPullCommand;
use Symfony\Component\Console\Tester\CommandTester;


class RepoPullCommandTest extends TestCase {

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
        $this->mock->shouldReceive('pull')
            ->once()
            ->with('repo', 'origin')
            ->andReturn(true);

        $command = new RepoPullCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['repo' => 'repo', 'remote' => 'origin']);
        
        $this->assertEquals('pull repo <<-- origin Success.', $tester->getDisplay());
    }

}
