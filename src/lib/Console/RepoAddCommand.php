<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\Git;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoAddCommand extends BaseCommand {

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
        $this->setName('repo:add')
            ->setDescription('Add files to existing git repo.')
            ->addArgument('file', InputArgument::OPTIONAL, 'Add individual file', '.')
            ->addOption('files', null, InputOption::VALUE_OPTIONAL, 'Add multiple files. Defaults to "."', '.');
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $repo = $this->getRepo();
        $file = $this->getFile();

        $result = $this->git->add($repo, $file);

        if($result)
            $this->displayOutput('Files successfully added. Ready for commit.');
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
    * Get the file to add to repo.
    *
    * @return string
    */
    protected function getFile()
    {
        return $this->argument('file');
    }

    /**
    * Get the files to add to repo.
    *
    * @return string
    */
    protected function getFiles()
    {
        return $this->option('files');
    }
}
