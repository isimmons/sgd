<?php namespace Isimmons\Sgd\Console;

use Isimmons\Sgd\SculpinCopier;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SculpinCopyCommand extends BaseCommand {

    /**
    * Injected instance of SculpinCopier class
    *
    * @var Isimmons\Sgd\Git
    */
    protected $copier;

    /**
    * Create an instance of AddCommand
    *
    * @param Isimmons\Sgd\SculpinCopier git
    * @return void
    */
    public function __construct(SculpinCopier $copier)
    {
        parent::__construct();

        $this->copier = $copier;
    }

    /**
    * Configure command options
    *
    * @return void
    */
    protected function configure()
    {        
        $this->setName('sculpin:copy')
            ->setDescription('Copy files from sculpin build directory to local git repo')
            ->addArgument('src', InputArgument::REQUIRED, 'Path to sculpin build directory (Required)')
            ->addArgument('dest', InputArgument::REQUIRED, 'Path to target repository (Required)');
    }

    /**
    * Execute the command.
    *
    * @return void
    */
    protected function fire()
    {
        $src = $this->getSrc();
        $dest = $this->getDest();
        if($this->copier->copy($src, $dest))
            $this->displayOutput("Files successfully copied from {$src} to {$dest}.");
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
    protected function getSrc()
    {
        return $this->argument('src');
    }

    /**
    * Get the files to add to repo.
    *
    * @return string
    */
    protected function getDest()
    {
        return $this->argument('dest');
    }
}
