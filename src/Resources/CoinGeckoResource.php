<?php

namespace CoinGecko\Resources;

use CoinGecko\Client;
use CoinGecko\Exception\CoinGeckoException;
use CoinGecko\Response;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/*
    Coin Gecko API Resource Class
    Abstract class that handles different requests type for API
*/

abstract class CoinGeckoResource extends BaseResource
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * The ID of the resource
     *
     * If provided, the actions will be called against that specific resource ID
     *
     * @var array|string|int|null
     */
    protected $id;

    /**
     * @var CoinGeckoResource|null
     */
    protected $parent;

    /**
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * HTTP request headers
     *
     * @var array
     */
    protected $httpHeaders = [];

    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey;

    /**
     * List of child Resource names / classes
     *
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = [];

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = false;

    /**
     * List of custom GET / POST / PUT / DELETE actions
     *
     * Methods can be called like directly without using get(), post(), put() or delete().
     * @example cod(), service_history(), statistics()
     * For array item that has associative key => value pair, value will be treated as method name.
     *
     * @var array $customGetActions
     * @var array $customPostActions
     * @var array $customPutActions
     * @var array $customDeleteActions
     */
    protected $customGetActions = [];
    protected $customPostActions = [];
    protected $customPutActions = [];
    protected $customDeleteActions = [];

    /**
     * List of actions for raw response without using json_decode.
     *
     * @var array
     */
    protected $rawResponseActions = [];

    /**
     * Determines if response should be as JSON.
     *
     * @var bool
     */
    protected $returnJson = true;


    /**
     * @param Client $client
     * @param int|null $id
     * @param CoinGeckoResource $parentResource
     */
    public function __construct (Client $client, $id = null, $parentResource = null)
    {
        $this->client = $client;
        $this->id = $id;
        $this->parent = $parentResource;
    }

    /**
     * Return CoinGeckoResource instance for the child resource.
     *
     * @param string $childName
     *
     * @return CoinGeckoResource
     */
    public function __get ($childName)
    {
        return $this->$childName();
    }

    /**
     * Return CoinGeckoResource instance for the child resource or call a custom action for the resource
     *
     * If $name starts with lowercase letter it's action or custom action, uppercase means it's class name.
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws CoinGeckoException if the $name is not a valid child resource or custom action method.
     *
     * @return mixed / CoinGeckoResource
     */
    public function __call ($name, $arguments)
    {
        //If the $name starts with an uppercase letter, it's considered as a child class
        //Otherwise it's a custom action
        if (ctype_upper($name[0])) {
            //Get the array key of the childResource in the childResource array
            $childKey = array_search($name, $this->childResource);

            if ($childKey === false) {
                throw new CoinGeckoException("Child Resource $name is not available for " . $this->getResourceName());
            }

            //If any associative key is given to the childname, then it will be considered as the class name,
            //otherwise the childname will be the class name
            $childClassName = !is_numeric($childKey) ? $childKey : $name;

            $childClass = __NAMESPACE__ . "\\" . $childClassName;

            //If first argument is provided, it will be considered as the ID of the resource.
            $resourceID = !empty($arguments) ? $arguments[0] : null;

            if (count($arguments) > 1) {
                $resourceID = $arguments;
            }

            return new $childClass($this->client, $resourceID, $this);
        } else {
            $actionMaps = [
                'get' => 'customGetActions',
            ];

            // Get the array key for the action in the actions array
            foreach ($actionMaps as $httpMethod => $actionArrayKey) {
                $actionKey = array_search($name, $this->$actionArrayKey);
                if ($actionKey !== false) break;
            }

            if ($actionKey === false) {
                throw new CoinGeckoException("No action named $name is defined for " . $this->getResourceName());
            }

            //If any associative key is given to the action, then it will be considered as the method name,
            //otherwise the action name will be the method name
            $customAction = !is_numeric($actionKey) ? $actionKey : $name;

            $params = !empty($arguments) ? $arguments[0] : [];

            $url = $this->generateUrl($params, $customAction);
            $url = str_replace('%5B0%5D', '[]', $url);

            return $this->$httpMethod($params, $url);
        }
    }

    /**
     * Get the resource name (or the class name)
     *
     * @return string
     */
    public function getResourceName ()
    {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    /**
     * Get the resource key (it's mostly used to generate api url)
     *
     * @return string
     */
    protected function getResourceKey ()
    {
        return $this->resourceKey;
    }

    /**
     * Get HTTP headers as array.
     *
     * @return array
     */
    protected function getHttpHeaders ()
    {
        return $this->httpHeaders;
    }

    /**
     * Generate the custom url for api request based on the params and custom action (if any)
     *
     * @param array $params
     * @param string $customAction
     *
     * @return string
     */
    public function generateUrl ($params = [], $customAction = null)
    {
        $config = $this->client->getConfig();
        $url = '';

        if ($this->parent) {
            $url = $this->parent->generateUrl([], null);
        } else {
            $url = $config['api_url'];
        }

        if (!empty($url) && strrpos($url, '/') !== strlen($url) - 1) {
            $url .= '/';
        }

        $url .= $this->getResourceKey();

        if ($this->id) {
            if (is_array($this->id)) {
                foreach ($this->id as $id) {
                    $url .= '/' . $id;
                }
            } else {
                $url .= '/' . $this->id;
            }
        }

        if ($customAction) {
            $url .= '/' . $customAction;
        }

        if (!empty($config['api_key'])) {
            $params['x_cg_pro_api_key'] = $config['api_key'];
        }

        if (!empty($params)) {
            $url .= '?' . http_build_query($params, '', null, PHP_QUERY_RFC3986);
        }

        return $url;
    }

    /**
     * Generate HTTP GET request and return results as an array
     *
     * @param array $params
     * @param null|string $url
     *
     * @return mixed
     *
     * @throws ClientException
     * @throws ConnectException
     * @throws RequestException
     */
    public function get ($params = [], $url = null)
    {
        if (!$url) $url = $this->generateUrl($params);

        try {
            return $this->fillFromResponse(new Response(
                    $this->client->getHttpClient()->get($url, [
                            'headers' => $this->getHttpHeaders(),
                            'query' => $params,
                        ]
                    )
                )
            );
        } catch (\Exception $e) {
            throw new CoinGeckoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param Response $response
     *
     * @return $this|null
     */
    protected function fillFromResponse (Response $response)
    {
        if ($this->returnJson === true) {
            $data = $response->toArray();
        } else {
            $data = $response->getContents();
        }

        $this->data = [];
        $this->changedData = [];

        if (empty($data)) {
            return $data;
        }

        $this->data = $data;

        return $this->getData();
    }
}
