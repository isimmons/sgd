<?php

use Isimmons\Sgd\Git;
use Symfony\Component\Console\Tester\CommandTester;

class GitTest extends TestCase {

    public function setUp()
    {
        $this->mock = Mockery::mock('Isimmons\Sgd\GitRunner');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItAddsFilesToRepo()
    {        
        $this->mock->shouldReceive('run')
            ->with('repo', 'add testfile')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->add('repo', 'testfile');
        
        $this->assertTrue($result);
    }

    public function testItCommitsFiles()
    {
        $this->mock->shouldReceive('run')
            ->with('repo', 'commit -m "message"')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->commit('repo', 'message');
        
        $this->assertTrue($result);
    }

    public function testItPushesChanges()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'push origin master')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->push('repo', 'origin', 'master');
        
        $this->assertTrue($result);
    }

    public function testItReturnsTrueIfValidRepo()
    {
        $this->mock->shouldReceive('validate')
            ->once()
            ->with('repo')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->validate('repo');

        $this->assertTrue($result);
    }

    public function testItReturnsFalseIfInvalidRepo()
    {
        $this->mock->shouldReceive('validate')
            ->once()
            ->with('repo')
            ->andReturn(false);

        $git = new Git($this->mock);
        $result = $git->validate('repo');

        $this->assertFalse($result);
    }

    public function testItCreatesRepo()
    {
        $this->mock->shouldReceive('make')
            ->once()
            ->with('repo')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->make('repo');

        $this->assertTrue($result);
    }

    public function testItFailsToCreateRepo()
    {
        $this->mock->shouldReceive('make')
            ->once()
            ->with('repo')
            ->andReturn(false);

        $git = new Git($this->mock);
        $result = $git->make('repo');

        $this->assertFalse($result);
    }

    public function testItChecksRepoStatus()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'status')
            ->andReturn('status');

        $git = new Git($this->mock);
        $result = $git->status('repo', 'status');

        $this->assertEquals($result, 'status');
    }

    public function testItAddsRemoteToRepo()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'remote add origin git@github.com:isimmons/foo.git')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->remote('repo', 'add', 'origin', 'git@github.com:isimmons/foo.git');
        
        $this->assertTrue($result);
    }

    public function testItRemovesRemoteFromRepo()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'remote rm origin git@github.com:isimmons/foo.git')
            ->andReturn(true);

        $git = new Git($this->mock);
        $result = $git->remote('repo', 'rm', 'origin', 'git@github.com:isimmons/foo.git');

        $this->assertTrue($result);
    }

    public function testItFailsToAddOrRemoveRemote()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'remote add origin git@github.com:isimmons/foo.git')
            ->andReturn(false);

        $git = new Git($this->mock);
        $result = $git->remote('repo', 'add', 'origin', 'git@github.com:isimmons/foo.git');

        $this->assertFalse($result);
    }

    public function testItFetchesFromRemote()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'fetch origin')
            ->andReturn(true);

        $git = new Git($this->mock);

        $result = $git->fetch('repo', 'origin');

        $this->assertTrue($result);
    }

    public function testItPullsFromRemote()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'pull origin')
            ->andReturn(true);

        $git = new Git($this->mock);

        $result = $git->pull('repo', 'origin');

        $this->assertTrue($result);
    }

     public function testItMergesFromRemote()
    {
        $this->mock->shouldReceive('run')
            ->once()
            ->with('repo', 'merge origin --commit')
            ->andReturn(true);

        $git = new Git($this->mock);

        $result = $git->merge('repo', 'origin');

        $this->assertTrue($result);
    }

}