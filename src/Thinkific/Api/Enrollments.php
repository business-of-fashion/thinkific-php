<?php

namespace Thinkific\Api;

class Enrollments extends AbstractApi
{
    /**
     *
     *
     * @param $data
     *
     * @return mixed
     */
    public function add($data)
    {
        $split = preg_split('/\\\/', get_class($this));

        return $this->client->request([
            "endpoint"   => strtolower(array_pop($split)),
            "httpmethod" => "POST",
            "query"      => $data,
        ]);
    }
}
