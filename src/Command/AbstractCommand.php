<?php


namespace Demo\SymfonyContainer\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractCommand extends Command implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;


    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function get($name)
    {
        return $this->container->get($name);
    }
}