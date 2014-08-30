<?php

namespace Remdan\EasysysConnectorBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Remdan\EasysysConnectorBundle\EasysysConnectorManager;

abstract class AbstractCommand extends ContainerAwareCommand
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var EasysysConnectorManager
     */
    protected $easysysConnectorManager;

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     * @return $this
     */
    public function setOutput(OutputInterface $output = null)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    public function setInput(InputInterface $input = null)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return EasysysConnectorManager
     */
    public function getEasysysConnectorManager()
    {
        return $this->easysysConnectorManager;
    }

    /**
     * @param EasysysConnectorManager $easysysConnectorManager
     * @return $this
     */
    public function setEasysysConnector(EasysysConnectorManager $easysysConnectorManager = null)
    {
        $this->easysysConnectorManager = $easysysConnectorManager;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isVerbose()
    {
        return $this->output->getVerbosity() > OutputInterface::VERBOSITY_NORMAL;
    }

    /**
     * @return boolean
     */
    public function isExtraVerbose()
    {
        return $this->output->getVerbosity() > OutputInterface::VERBOSITY_VERBOSE;
    }

    /**
     * @return boolean
     */
    public function isTest()
    {
        return $this->input->getOption('test');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->setFakeRequest();

        $this->setOutput($output);
        $this->setInput($input);

        $this->setInjections();
    }

    /**
     *
     */
    public function setInjections()
    {
        $this->initEasysysConnectorManager();
    }

    /**
     * @return $this
     */
    public function initEasysysConnectorManager()
    {
        $this->easysysConnectorManager = $this->getContainer()->get('remdan.easysysconnectorbundle.easysysconnectormanager');

        return $this;
    }

    /**
     *
     */
    public function setFakeRequest()
    {
        //TODO: create fake request
    }
}