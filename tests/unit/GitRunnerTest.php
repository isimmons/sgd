<?php

use Isimmons\Sgd\GitRunner;
use Isimmons\Sgd\Exceptions\GitCommandException;

class GitRunnerTest extends TestCase {

    public function setUp()
    {
        $this->markTestSkipped('Test skipped for safety reasons. See notes in Readme.md #Testing');
        $this->runner = new GitRunner;
    }

    public function tearDown()
    {
        $this->cleanResourcesDir();
    }


    public function testDetectsValidRepo()
    {        
        $result = $this->runner->validate(realpath(__DIR__.'../../resources/valid-repo/'));

        $this->assertTrue($result);
    }

    public function testDetectsInValidRepo()
    {        
        $result = $this->runner->validate(realpath(__DIR__.'../../resources/invalid-repo/'));

        $this->assertFalse($result);
    }

    public function testCreatesRepo()
    {
        $result = $this->runner->make(realpath(__DIR__.'../../resources') . '/repo');

        $this->assertTrue($result);
    }

    public function testItChecksRepoStatus()
    {
        $result = $this->runner->run(realpath(__DIR__.'../../resources/valid-repo/'), 'status');
        
        $this->assertTrue(str_contains($result, 'nothing to commit (create/copy files and use "git add" to track)'));
    }

    public function testItAddsRemote()
    {
        $dir = __DIR__.'../../resources/valid-repo-for-remote-test/';

        $result = $this->runner->run($dir, 'remote add origin git@github.com:isimmons/foo.git');

        if(str_contains($this->runner->run($dir, 'remote'), 'origin'))
        {
            $this->runner->run($dir, 'remote rm origin');
        }

        $this->assertEquals($result, '');
    }

    public function testItRemovesRemote()
    {
        $dir = __DIR__.'../../resources/valid-repo-for-remote-test/';

        if( ! str_contains($this->runner->run($dir, 'remote'), 'origin'))
        {
            $this->runner->run($dir, 'remote add origin git@github.com:isimmons/foo.git');
        }

        $result = $this->runner->run($dir, 'remote rm origin');

        $this->assertEquals($result, '');
    }

    public function testItFailsIfRemoteAlreadyExists()
    {
        $dir = __DIR__.'../../resources/valid-repo-for-remote-test/';

        if( ! str_contains($this->runner->run($dir, 'remote'), 'origin'))
        {
            $this->runner->run($dir, 'remote add origin git@github.com:isimmons/foo.git');
        }

        try {
            $result = $this->runner->run($dir, 'remote add origin git@github.com:isimmons/foo.git');
        } catch (GitCommandException $e) {
            $result = false;
        }

        $this->assertFalse($result);

        if(str_contains($this->runner->run($dir, 'remote'), 'origin'))
        {
            $this->runner->run($dir, 'remote rm origin');
        }
    }

    protected function cleanResourcesDir()
    {
        /*do NOT change this path or you will die!!!! No seriously, don't change it.
        * you might end up deleting something important like resource dirs needed
        * for other tests or even non test directories and files
        */
        $dir = realpath(__DIR__.'../../resources') . '/repo';

        if( is_dir($dir))
        {
            foreach(new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $dir, FilesystemIterator::SKIP_DOTS),
                     RecursiveIteratorIterator::CHILD_FIRST) as $path)
            {
                $path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
            }

            rmdir($dir);
        }
    }

}
