<?php

namespace Thinkific;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\QueryString;
use GuzzleHttp\Exception\ClientException;
use Thinkific\Aggregators\PhpAggregator;

class Thinkific
{

    protected $url = "https://api.thinkific.com/api/public/";
    protected $apiversion = 1;

    protected $httpClient;

    private $apikey;
    private $subdomain;

    protected $apis = [];
    protected $debug = false;

    function __construct($config = [])
    {

        if (isset($config['apikey'])) {
            $this->apikey = $config['apikey'];
        }
        if (isset($config['subdomain'])) {
            $this->subdomain = $config['subdomain'];
        }
        if (isset($config['debug'])) {
            $this->debug = $config['debug'];
        }

    }

    public function __call($method, $args)
    {
        return $this->getApi(ucwords($method));
    }

    /**
     * Returns the requested class name, optionally using a cached array so no
     * object is instantiated more than once during a request.
     *
     * @param string $class
     *
     * @return mixed
     */
    private function getApi($class)
    {
        $class = '\Thinkific\Api\\'.$class;

        if (!array_key_exists($class, $this->apis)) {
            $this->apis[$class] = new $class($this);
        }

        return $this->apis[$class];
    }

    /**
     * Create a Guzzle HTTP request
     *
     * @param $options
     *
     * @return mixed
     */
    public function request($options)
    {
        $reqoptions = [];

        $endpoint = $options['endpoint'];
        $method   = isset($options['httpmethod']) ? $options['httpmethod'] : 'GET';
        $body     = isset($options['body']) ? $options['body'] : [];

        $url = $this->url."v".$this->apiversion."/".$endpoint;
        if (isset($options['id'])) {
            $url .= "/".$options['id'];
        }

        if (isset($options['subentity'])) {
            $url .= '/'.strtolower($options['subentity']);
        }

        if (isset($options['query']) || isset($options['params'])) {
            $url .= "?";
            $params = [];

            if (isset($options['query'])) {
                $params['query'] = $options['query'];
            }

            if (isset($options['params'])) {
                $params = array_merge($params, $options['params']);
            }

            $url .= http_build_query($params);
        }

        $reqoptions['headers'] = [
            'Accept'           => 'application/json',
            'X-Auth-API-Key'   => $this->apikey,
            'X-Auth-Subdomain' => $this->subdomain,
            'Content-Type'     => 'form-data',
        ];

        try {
            $client = new Client();

            if ($method == 'POST') {
                $request = $client->post($url, $reqoptions['headers'], $body);
                $request->getPostFields()->setAggregator(new PhpAggregator());
            } else {
                $request = $client->createRequest($method, $url, $reqoptions['headers'], $body);
            }

            return $request->send()->json();

        } catch (ClientErrorResponseException $e) {
            $return         = $e->getResponse()->json();
            $return['code'] = $e->getResponse()->getStatusCode();

            return $return;
        }
    }

}


