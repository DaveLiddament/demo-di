<?php


namespace Demo\SymfonyContainer\Command;



use Demo\SymfonyContainer\ApiInterface\ApiManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SimulateContactsUpdateCommand extends AbstractCommand
{


    protected function configure()
    {
        $this->setName('simulate:contacts:update');
        $this->setDescription('Simulates calling UPDATE to API for contacts');
    }
    
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ApiManagerInterface $apiManager */
        $apiManager = $this->get("api.contacts");
        $output->writeln($apiManager->update());
    }


}