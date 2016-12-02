<?php
namespace Thinkific\Api;

use Thinkific\Thinkific;

abstract class AbstractApi
{
    protected $data;

    public function __construct(Thinkific $client)
    {
        $this->client = $client;
    }

    /**
     *
     *
     * @param array $params
     *
     * @return $this
     */
    public function query($params = [])
    {
        $split    = preg_split('/\\\/', get_class($this));
        $endpoint = strtolower(array_pop($split));

        $requestParams = [
            "endpoint" => $endpoint,
            "params"   => $params,
            "query"    => ((isset($params['query']) && !empty($params['query'])) ? $params['query'] : null),
        ];

        // @todo: Find proper solution for unset
        if (isset($params['id'])) {
            $requestParams['id'] = $params['id'];
            unset($requestParams['params']['id']);
        }

        if (isset($params['subentity'])) {
            $requestParams['subentity'] = $params['subentity'];
            unset($requestParams['params']['subentity']);
        }

        $this->data = $this->client->request($requestParams);

        return $this;
    }

    /**
     * Check if there is any error in request
     *
     * @return bool
     */
    public function isValid()
    {
        if (isset($this->data['error'])) {
            return false;
        }

        return true;
    }

    /**
     * Fetch items
     *
     * @return array
     */
    public function fetchItems()
    {
        if (!empty($this->data['items'])) {
            return $this->data['items'];
        }

        if (!isset($this->data['meta'])) {
            return $this->data;
        }

        return [];
    }

    /**
     * Fetch meta data
     *
     * @return array
     */
    public function fetchMeta()
    {
        if (!empty($this->data['meta'])) {
            return $this->data['meta'];
        }

        return [];
    }

    /**
     * Fetch All
     *
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->data;
    }

    /**
     * Get by Id
     *
     * @param      $id
     * @param null $subentity
     *
     * @return object
     */
    public function queryById($id, $subentity = null)
    {
        $params = [
            'id'        => $id,
            'subentity' => (isset($subentity) ? $subentity : null),
        ];

        $this->query($params);

        return $this;
    }

    /**
     * Add something via the Api
     *
     * @param $data
     *
     * @return mixed
     * @throws ApiException
     */
    public function add($data)
    {
        $split = preg_split('/\\\/', get_class($this));

        $result = $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "POST",
            "body"       => $data,
        ]);

        if (isset($result["errors"])) {
            throw new ApiException($result["errors"]);
        } else {
            return $result;
        }
    }

    /**
     * Updates a User
     *
     * @param $id   - Id of what to update
     * @param $data - Array of information to update
     *
     *
     * @return mixed
     * @throws ApiException
     */
    public function update($id, $data)
    {
        $split = preg_split('/\\\/', get_class($this));

        $result = $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "PUT",
            "id"         => $id,
            "body"       => $data,
        ]);

        if (isset($result["errors"])) {
            throw new ApiException($result["errors"]);
        } else {
            return $result;
        }

    }

    /**
     * Delete by Id
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {

        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "DELETE",
            "id"         => $id,
        ]);
    }
}