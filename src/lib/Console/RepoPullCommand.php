<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\Git;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoPullCommand extends BaseCommand {

    /**
    * Injected instance of Git class
    *
    * @var Isimmons\Sgd\Git
    */
    protected $git;

    /**
    * Create an instance of CommitCommand
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
        $this->setName('repo:pull')
            ->setDescription('Pull from remote.')
            ->addArgument('repo', InputArgument::REQUIRED, 'Path to target local repository (Required)')
            ->addArgument('remote', InputArgument::REQUIRED, 'Remote repository');
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $repo = $this->getRepo();
        $remote = $this->getRemote();

        if($this->git->pull($repo, $remote))
            $this->displayOutput("pull {$repo} <<-- {$remote} Success.");
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
    * Get the remote repository to push to
    *
    * @return string
    */
    protected function getRemote()
    {
        return $this->argument('remote');
    }
}
