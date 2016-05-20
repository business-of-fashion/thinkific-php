<?php

namespace Thinkific\Api;

class Courses extends AbstractApi
{
    /**
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
}
