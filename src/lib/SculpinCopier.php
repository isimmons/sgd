<?php namespace Isimmons\Sgd;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class SculpinCopier {

    public function copy($src, $dest)
    {
        foreach(
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST) as $item
        )
        {
            if ($item->isDir())
            {
                $newDir = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
                 
                if( ! is_dir($newDir)) mkdir($newDir);
            }
            else
            {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
        
        return true;
    }

}
