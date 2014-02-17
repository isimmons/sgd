<?php

use Isimmons\Sgd\SculpinCopier;

class SculpinCopierTest extends TestCase {

    public function setUp()
    {
        $this->markTestSkipped('Test skipped for safety reasons. See notes in Readme.md #Testing');
    }

    public function tearDown()
    {
        $this->cleanResourcesDir();
    }

    public function testItCopiesFilesFromSrcToDest()
    {
        $copier = new SculpinCopier;
        $src = realpath(__DIR__.'../../resources') . '/copier/src';
        $dest = realpath(__DIR__.'../../resources') . '/copier/dest';
        
        $result = $copier->copy($src, $dest);

        $this->assertTrue($result);
    }

    protected function cleanResourcesDir()
    {
        /*do NOT change this path or you will die!!!! No seriously, don't change it.
        * you might end up deleting something important like resource dirs needed
        * for other tests or even non test directories and files
        */
        $dir = realpath(__DIR__.'../../resources') . '/copier/dest';

        if( is_dir($dir))
        {
            foreach(new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $dir, FilesystemIterator::SKIP_DOTS),
                     RecursiveIteratorIterator::CHILD_FIRST) as $path)
            {
                $path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
            }
        }
    }


}