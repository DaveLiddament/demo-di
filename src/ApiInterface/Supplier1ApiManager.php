<?php


namespace Demo\SymfonyContainer\ApiInterface;


class Supplier1ApiManager implements ApiManagerInterface
{

    private $baseUrl;
    private $config;

    /**
     * Supplier1ApiManager constructor.
     * @param $baseUrl
     * @param $config
     */
    public function __construct($baseUrl, array $config)
    {
        $this->baseUrl = $baseUrl;
        $this->config = $config;
    }


    public function get()
    {
        return "Supplier 1 GET method called. Base URL [{$this->baseUrl}]  Config: " . var_export($this->config, true);
    }

    public function update()
    {
        return "Supplier 1 UPDATE method called. Base URL [{$this->baseUrl}]  Config: " . var_export($this->config, true);
    }
}