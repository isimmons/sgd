<?php namespace Isimmons\Sgd;

use Isimmons\Sgd\GitRunner;

class Git {
    
    /**
    * Instance of the GitRunner
    *
    * @var Isimmons\Sgd\GitRunner
    */
    protected $runner;

    /**
    * Create an instance of Git
    *
    * @param Isimmons\Sgd\GitRunner runner
    * @return void
    */
    public function __construct(GitRunner $runner)
    {
        $this->runner = $runner;
    }

    /**
    * Runs the git add command
    *
    * @param string files
    * @return boolean
    */
    public function add($repo, $files = '.')
    {
        $command = "add {$files}";

        $git = $this->runner;

        $git->run($repo, $command);

        return true;
    }

    /**
    * Runs the git commit command
    *
    * @param string message
    * @return boolean
    */
    public function commit($repo, $message = "New Post")
    {
        $command = 'commit -m ' . escapeshellarg($message);

        $git = $this->runner;

        $git->run($repo, $command);

        return true;
    }

    /**
    * Runs the git push command
    *
    * @param string remote
    * @param string branch
    * @return void
    */
    public function push($repo, $remote = "origin", $branch = "master")
    {
        $command = "push {$remote} {$branch}";

        $git = $this->runner;

        $git->run($repo, $command);

        return true;
    }

    public function validate($repo)
    {
        if($this->runner->validate($repo))
            return true;

        return false;
    }

    public function make($repo)
    {
        if($this->runner->make($repo))
            return true;

        return false;
    }

    public function status($repo)
    {
        $command = "status";

        $git = $this->runner;

        if($result = $git->run($repo, $command)) return $result;

        return false;
    }

    public function remote($repo, $action = 'add', $remote = 'origin', $url)
    {
        $command = "remote {$action} {$remote} {$url}";

        $git = $this->runner;

        $result = $git->run($repo, $command);
        
        if($result === true) return true;

        return false;
    }

    public function fetch($repo, $remote)
    {
        $command = "fetch {$remote}";

        $git = $this->runner;

        if($result = $git->run($repo, $command)) return true;

        return false;
    }

    public function pull($repo, $remote, $branch)
    {
        $command = "pull {$remote} {$branch}";

        $git = $this->runner;

        $result = $git->run($repo, $command);
        
        if($result === true) return true;

        return false;
    }

    public function merge($repo, $remote, $commit = false)
    {
        $command = "merge {$remote} " . $commit = true ? '--commit' : '';

        $git = $this->runner;

        if($result = $git->run($repo, $command)) return true;

        return false;
    }
}
