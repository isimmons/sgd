<?php namespace Isimmons\Sgd\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Isimmons\Sgd\Exceptions\ConfigFileException;

abstract class BaseCommand extends SymfonyCommand {

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        return $this->fire();
    }

    /**
     * Get an argument from the input.
     *
     * @param  string  $key
     * @return string
     */
    public function argument($key)
    {
        if( ! $this->getConfig($key))
        {
            return $this->ask("Enter the path where you would like this new repository.");
        }

        return $this->getConfig($key);

    }

    /**
     * Get an option from the input.
     *
     * @param  string  $key
     * @return string
     */
    public function option($key)
    {
        return $this->input->getOption($key);
    }

    /**
     * Ask the user the given question.
     *
     * @param  string  $question
     * @return string
     */
    public function ask($question)
    {
        $question = '<comment>'.$question.'</comment> ';

        return $this->getHelperSet()->get('dialog')->ask($this->output, $question);
    }

    /**
     * Ask the user the given secret question.
     *
     * @param  string  $question
     * @return string
     */
    public function secret($question)
    {
        $question = '<comment>'.$question.'</comment> ';

        return $this->getHelperSet()->get('dialog')->askHiddenResponse($this->output, $question, false);
    }

    protected function getConfig($key)
    {
        if( ! $json = file_get_contents('./sgd.json')) return false;

        if( ! $config = json_decode($json, true)) throw new ConfigFileException('Something is wrong with your config file.');

        if(isset($config[$key])) return $config[$key];

        return false;
    }

}