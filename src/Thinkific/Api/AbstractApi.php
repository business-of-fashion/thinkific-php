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
        $split = preg_split('/\\\/', get_class($this));

        $requestParams = [
            "endpoint" => strtolower(array_pop($split)),
            "params"   => $params,
        ];

        if (isset($params['id'])) {
            $requestParams['id'] = $params['id'];
            unset($requestParams['params']['id']);
        }

        if (isset($params['query']) && !empty($params['query'])) {
            $requestParams['query'] = $params['query'];
        }

        $this->data = $this->client->request($requestParams);

        return $this;
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
     * @param $id
     *
     * @return object
     */
    public function queryById($id)
    {
        $this->query(['id' => $id]);

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