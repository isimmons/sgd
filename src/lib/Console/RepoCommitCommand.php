<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\Git;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoCommitCommand extends BaseCommand {

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
        $this->setName('repo:commit')
            ->setDescription('Commit staged files.')
            ->addArgument('message', InputArgument::OPTIONAL, 'Commit message', 'New Post');
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $repo = $this->getRepo();
        $message = $this->getMessage();
        
        $result = $this->git->commit($repo, $message);

        if($result)
            $this->displayOutput('Files successfully commited. Ready to push.');
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
    * Get the repo path
    *
    * @return string
    */
    protected function getRepo()
    {
        return $this->argument('repo');
    }

    /**
    * Get the commit message
    *
    * @return string
    */
    protected function getMessage()
    {
        return $this->argument('message');
    }

}
