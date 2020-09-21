<?php

namespace Saraceno\JsonRpc\Services;

class EmptyResponse
{

    /**
     * @return string
     */
    public function asString()
    {
        return "";
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return [];
    }
}