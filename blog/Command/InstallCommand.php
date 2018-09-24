<?php

namespace VZenix\Bundle\BlogBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('vzenix:blog-install')
            ->setDescription('Blog install.')
            ->setHelp('This cmd allow to initializate the blog bundle');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('[vzenix/blog] / Install script');
        // throw new \Exception("Error Processing Request", 500);
    }
}