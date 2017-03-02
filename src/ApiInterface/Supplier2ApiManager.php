<?php


namespace Demo\SymfonyContainer\ApiInterface;


class Supplier2ApiManager implements ApiManagerInterface
{

    private $baseUrl;
    private $config;

    /**
     * Supplier2ApiManager constructor.
     * @param $baseUrl
     * @param $config
     * @param $contentType
     */
    public function __construct($baseUrl, array $config, $contentType)
    {
        $this->baseUrl = $baseUrl;
        $this->config = $config[$contentType];
    }


    public function get()
    {
        return "Supplier 2 GET method called. Base URL [{$this->baseUrl}]  Config: " . var_export($this->config, true);
    }

    public function update()
    {
        return "Supplier 2 UPDATE method called. Base URL [{$this->baseUrl}]  Config: " . var_export($this->config, true);
    }
}