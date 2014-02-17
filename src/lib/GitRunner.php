<?php namespace Isimmons\Sgd;

use Isimmons\Sgd\Exceptions\GitCommandException;

class GitRunner {

    /**
    * Path to the git binary based on OS architecture
    *
    * @var string
    */
    protected $gitBin;

    /**
    * Extra environment options can be set by user
    *
    * @var array
    */
    protected $envOptions = [];

    /**
    * Create a new instance of the GitRunner
    *
    * @param string repo
    * @return void
    */
    public function __construct()
    {
        $this->setBin();
    }

    /**
    * Set the git binary based on OS
    *
    * @return void
    */
    protected function setBin()
    {
        if (str_contains(strtolower(php_uname()), 'win'))
        {
            //windows (git should be in system or user path)
            $this->gitBin = 'git';
        }
        else
        {
            //linux/mac
            $this->gitBin = '/usr/bin/git';
        }
    }

    /**
     * Run a command in the git repository
     *
     * Accepts a shell command to run
     *
     * @access  public
     * @param   string  command to run
     * @return  string
     */
    public function run($repo, $command)
    {        
        $command = $this->gitBin . " " . $command;
        
        // resolve possible empty $_ENV
        $env = $this->prepareEnv();
        
        $descriptorspec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $pipes = [];
        $cwd = $repo;

        if( ! $this->validate($repo)) throw new GitCommandException('Is not a working repository.');

        //maybe use is_resource() here

        if( !$resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env))
            throw new GitCommandException(
                'Command Failed: Make sure you entered the command correctly and this is working repository.');

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe)
        {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));
        
        if ($status && $stderr != '') throw new GitCommandException($stderr);

        return $stdout;
    }

    protected function prepareEnv()
    {
        /* Depending on the value of variables_order, $_ENV may be empty.
         * In that case, we have to explicitly set the new variables with
         * putenv, and call proc_open with env=null to inherit the reset
         * of the system.
         */
        if(empty($_ENV))
        {
            $env = NULL;

            foreach($this->envOptions as $key => $val)
            {
                putenv(sprintf("%s=%s", $key, $val));
            }
        }
        else
        {
            $env = array_merge($_ENV, $this->envOptions);
        }

        return $env;
    }

    /**
     * Sets custom environment options for calling Git
     *
     * @param string key
     * @param string value
     */
    // public function setenv($key, $value) {
    //     //not implemented yet
    //     $this->envopts[$key] = $value;
    // }

    /**
    * Check if the given repo is actually a repo
    *
    * @param string repo
    * @return boolean
    */
    public function validate($repo)
    {
        
        if(is_dir($repo))
        {
            if(is_dir("{$repo}/.git")) return true;
        }

        return false;  
    }

    public function make($repo)
    {
        if( ! is_dir($repo))
        {
            mkdir($repo, 0777);
            $this->makeRepoRunner($repo);
            return true;
        }

        throw new GitCommandException('The directory already exists');
    }

    //special runner just for making repos
    protected function makeRepoRunner($repo)
    {
        $command = $this->gitBin . " " . 'init';
        
        // resolve possible empty $_ENV
        $env = $this->prepareEnv();
        
        $descriptorspec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $pipes = [];
        $cwd = $repo;

        if( !$resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env))
            throw new GitCommandException(
                'Command Failed: Make sure you entered the command correctly and this is working repository.');

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe)
        {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));

        if ($status) throw new GitCommandException($stderr);

        return $stdout;
    }

}
