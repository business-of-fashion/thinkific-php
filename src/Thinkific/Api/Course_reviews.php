<?php

namespace Thinkific\Api;

class Course_reviews extends AbstractApi
{

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