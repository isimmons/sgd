<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\Git;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoValidateCommand extends BaseCommand {

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
        $this->setName('repo:validate')
            ->setDescription('Check if directory is a valid git repository.');
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $repo = $this->getRepo();

        $result = $this->git->validate($repo); 

        if($result)
        {
            $this->displayOutput("{$repo} is a valid repository.");
        }
        else
        {
            $this->displayOutput("{$repo} NOT a valid repository.");
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

}
