<?php

namespace Thinkific\Api;

class Users extends AbstractApi
{

    /**
     *
     *
     * @param $query
     * @param $params
     *
     * @return mixed
     */
    public function query($query, $params)
    {
        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "GET",
            "query"      => $query,
            "params"     => $params,
        ]);
    }
}
