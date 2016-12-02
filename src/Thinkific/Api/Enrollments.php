<?php

namespace Thinkific\Api;

class Enrollments extends AbstractApi
{
    /**
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
            "query"      => $data,
        ]);

        if (isset($result["errors"])) {
            throw new ApiException($result["errors"], $result['code']);
        } else {
            return $result;
        }
    }
}
