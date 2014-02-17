<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\Git;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoRemoteCommand extends BaseCommand {

    /**
    * Injected instance of Git class
    *
    * @var Isimmons\Sgd\Git
    */
    protected $git;

    /**
    * Create an instance of AddCommand
    *
    * @param Isimmons\Sgd\Git git
    * @return void
    */
    public function __construct(Git $git)
    {
        parent::__construct();

        $this->git = $git;
    }

    /**
    * Configure command options
    *
    * @return void
    */
    protected function configure()
    {        
        $this->setName('repo:remote')
            ->setDescription('Add a remote to the repo.')
            ->addArgument('repo', InputArgument::REQUIRED, 'Path to target local repository (Required)')
            ->addArgument('action', InputArgument::REQUIRED, "'add' or 'remove (Required)'")
            ->addArgument('url', InputArgument::REQUIRED, 'Url to the remote repository (Required)')
            ->addArgument('remote', InputArgument::OPTIONAL, 'Remote repository name', 'origin');
            
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $repo = $this->getRepo();
        $remote = $this->getRemoteName();
        $url = $this->getUrl();
        $action = $this->getAction();

        if($this->git->remote($repo, $action, $remote, $url))
        {
            if($action == 'add')
            {
                $this->displayOutput("{$remote} {$url} added to {$repo}");
            }
            else
            {
                $this->displayOutput("{$remote} {$url} removed from {$repo}");
            }            
        }
        else
        {
            $this->displayOutput("Fail: Unable to add/remove remote '{$remote}' @url '{$url}' to repo '{$repo}'");
        }

    }

    /**
     * Display the given output line.
     *
     * @param  string  $output
     * @return void
     */
    protected function displayOutput($output)
    {
        $this->output->write($output);
    }

    /**
    * Get the repo path.
    *
    * @return string
    */
    protected function getRepo()
    {
        return $this->argument('repo');
    }

    /**
    * Get the name of the remote.
    *
    * @return string
    */
    protected function getRemoteName()
    {
        return $this->argument('remote');
    }

    /**
    * Get the remote url.
    *
    * @return string
    */
    protected function getUrl()
    {
        return $this->argument('url');
    }

     /**
    * Get the action (add/remove).
    *
    * @return string
    */
    protected function getAction()
    {
        return $this->argument('action');
    }

}
