<?php

use Isimmons\Sgd\Console\SculpinCopyCommand;
use Symfony\Component\Console\Tester\CommandTester;

class SculpinCopyCommandTest extends TestCase {

    public function setUp()
    {
        $this->mock = Mockery::mock('Isimmons\Sgd\SculpinCopier');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItCopiesSculpinFiles()
    {
        $this->mock->shouldReceive('copy')
            ->once()
            ->with('foo', 'bar')
            ->andReturn(true);

        $command = new SculpinCopyCommand($this->mock);

        $tester = new CommandTester($command);
        $tester->execute(['src' => 'foo', 'dest' => 'bar']);
        
        $this->assertEquals('Files successfully copied from foo to bar.', $tester->getDisplay());
    }

}
