<?php
namespace Thinkific\Api;

use Thinkific\Thinkific;

abstract class AbstractApi
{

    public function __construct(Thinkific $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getAll($params = [])
    {

        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint" => strtolower(array_pop($split)),
            "params"   => $params,
        ])['items'];
    }

    /**
     * Get an object by Id
     *
     * @param $id
     *
     * @return object
     */
    public function getById($id)
    {

        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint" => strtolower(array_pop($split)),
            "id"       => $id,
        ]);
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