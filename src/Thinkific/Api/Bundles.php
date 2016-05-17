<?php

namespace Thinkific\Api;

class Bundles extends AbstractApi
{
    /**
     * @throws ApiException
     */
    public function getAll()
    {
        throw new ApiException(["Not Supported" => ["The API Call 'getAll()' is not supported by the Thinkific Api"]]);
    }

    /**
     * @param $data
     *
     * @return mixed|void
     * @throws ApiException
     */
    public function add($data)
    {
        throw new ApiException(["Not Supported" => ["The API Call 'add()' is not supported by the Thinkific Api"]]);
    }

    /**
     * @param $id
     *
     * @return mixed|void
     * @throws ApiException
     */
    public function delete($id)
    {
        throw new ApiException(["Not Supported" => ["The API Call 'delete()' is not supported by the Thinkific Api"]]);
    }

    /**
     * @param $id
     *
     * @return object|void
     * @throws ApiException
     */
    public function getById($id)
    {
        throw new ApiException(["Not Supported" => ["The API Call 'getById()' is not supported by the Thinkific Api"]]);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed|void
     * @throws ApiException
     */
    public function update($id, $data)
    {
        throw new ApiException(["Not Supported" => ["The API Call 'update()' is not supported by the Thinkific Api"]]);
    }
}