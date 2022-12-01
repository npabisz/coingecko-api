<?php

namespace CoinGecko;

/*
--------------------------------------------------------------------------
 CoinGecko API Client Class
--------------------------------------------------------------------------
 This class initializes HTTP client and resource objects.
*/

use CoinGecko\Resources\AssetPlatforms;
use CoinGecko\Resources\CoinGeckoResource;
use CoinGecko\Resources\Coins;
use CoinGecko\Resources\Companies;
use CoinGecko\Resources\Derivatives;
use CoinGecko\Resources\ExchangeRates;
use CoinGecko\Resources\Exchanges;
use CoinGecko\Resources\Globals;
use CoinGecko\Resources\Indexes;
use CoinGecko\Resources\Nfts;
use CoinGecko\Resources\Ping;
use CoinGecko\Resources\Search;
use CoinGecko\Resources\Simple;

use CoinGecko\Exception\CoinGeckoException;

/**
 * @property-read Ping $Ping
 * @property-read Simple $Simple
 * @property-read Coins $Coins
 * @property-read AssetPlatforms $AssetPlatforms
 * @property-read Exchanges $Exchanges
 * @property-read Indexes $Indexes
 * @property-read Derivatives $Derivatives
 * @property-read Nfts $Nfts
 * @property-read ExchangeRates $ExchangeRates
 * @property-read Search $Search
 * @property-read Globals $Global
 * @property-read Companies $Companies
 *
 * @method Ping Ping()
 * @method Simple Simple()
 * @method Coins Coins(string $coinId = null)
 * @method AssetPlatforms AssetPlatforms()
 * @method Exchanges Exchanges(string $exchangeId = null)
 * @method Indexes Indexes(string $marketId = null, $indexId = null)
 * @method Derivatives Derivatives()
 * @method Nfts Nfts(string $id = null)
 * @method ExchangeRates ExchangeRates()
 * @method Search Search()
 * @method Globals Global()
 * @method Companies Companies()
 */
class Client
{
    const API_MODE_PRO = 'pro';

    /**
     * HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * List of resources available for client.
     *
     * @var string[]
     */
    protected $resources = [
        'Ping',
        'Simple',
        'Coins',
        'AssetPlatforms',
        'Exchanges',
        'Indexes',
        'Derivatives',
        'Nfts',
        'ExchangeRates',
        'Search',
        'Globals' => 'Global',
        'Companies',
    ];

    /**
     * Default API URL
     *
     * @var string
     */
    public static $defaultApiUrl  = 'https://api.coingecko.com/api/v3/';

    /**
     * Default API Pro URL
     *
     * @var string
     */
    public static $defaultApiProUrl  = 'https://pro-api.coingecko.com/api/v3/';

    /**
     * HTTP Client / API configurations
     *
     * @var array
     */
    protected $config = [];

    /**
     * List of resources which are only available through a parent resource
     *
     * @var array Array key is the child resource name and array value is the parent resource name
     */
    protected $childResources = [

    ];

    /**
     * API Client constructor
     *
     * @param array $config
     * @param array $httpOptions
     */
    public function __construct (array $config = [], array $httpOptions = [])
    {
        $this->configure($config);
        $this->httpClient = new \GuzzleHttp\Client($httpOptions);
    }

    /**
     * Return Resource instance for a resource.
     * @example $client->Ping->get(); //Returns ping
     * It can be used like an object properties.
     *
     * @param string $resourceName
     *
     * @return CoinGeckoResource
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * Return Resource instance for a resource.
     * Used like an object method optionally with the resource ID as the first argument
     * @example $client->Simple->TokenPrice($tokenId); //Return information about token price defined by $tokenId
     *
     * @param string $resourceName
     * @param array $arguments
     *
     * @throws CoinGeckoException if there is no ShipXResource resource with $name.
     *
     * @return CoinGeckoResource
     */
    public function __call ($resourceName, $arguments)
    {
        if (!in_array($resourceName, $this->resources)) {
            if (isset($this->childResources[$resourceName])) {
                $message = "$resourceName cannot be accessed directly, it's a child resource of " . $this->childResources[$resourceName] . ".";
            } else {
                $message = "There is no such resource $resourceName. Check CoinGecko API documentation to see the list of available resources.";
            }

            throw new CoinGeckoException($message);
        }

        $childKey = array_search($resourceName, $this->resources);
        $childClassName = !is_numeric($childKey) ? $childKey : $resourceName;

        $resourceClassName = __NAMESPACE__ . "\\Resources\\$childClassName";

        //If there are any arguments, first one is an ID of resource
        $resourceId = !empty($arguments) ? $arguments[0] : null;

        if (count($arguments) > 1) {
            $resourceId = $arguments;
        }

        return new $resourceClassName($this, $resourceId);
    }

    /**
     * Configure the API client
     *
     * @param array $config
     *
     * @return $this
     */
    public function configure (array $config)
    {
        $this->config = array_merge([
            'api_url' => self::$defaultApiUrl,
            'api_key' => '',
        ], $this->config);

        if (!empty($config['api_mode']) && strtolower($config['api_mode']) === self::API_MODE_PRO) {
            $this->config['api_url'] = self::$defaultApiProUrl;
        } else {
            $this->config['api_url'] = self::$defaultApiUrl;
        }

        if (!empty($config['api_url'])) {
            $this->config['api_url'] = $config['api_url'];
        }

        if (!empty($config['api_key'])) {
            // x_cg_pro_api_key param
            $this->config['api_key'] = $config['api_key'];
        }

        if (!empty($config['params'])) {
            foreach ($config['params'] as $key => $value) {
                $this->config['params'][$key] = $value;
            }
        }

        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient ()
    {
        return $this->httpClient;
    }

    /**
     * @return array
     */
    public function getConfig ()
    {
        return $this->config;
    }
}
