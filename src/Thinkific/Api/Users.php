<?php

namespace Thinkific\Api;

class Users extends AbstractApi
{

    /**
     *
     *
     * @param $data
     *
     * @return mixed
     */
    public function query($data)
    {
        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "GET",
            "query"      => $data,
        ]);
    }
}
