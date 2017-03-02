<?php


namespace Demo\SymfonyContainer\Command;



use Demo\SymfonyContainer\ApiInterface\ApiManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SimulatePaymentsUpdateCommand extends AbstractCommand
{


    protected function configure()
    {
        $this->setName('simulate:payments:update');
        $this->setDescription('Simulates calling UPDATE to API for payments');
    }
    
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ApiManagerInterface $apiManager */
        $apiManager = $this->get("api.payments");
        $output->writeln($apiManager->update());
    }


}