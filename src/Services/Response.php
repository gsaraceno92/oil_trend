<?php

namespace Saraceno\JsonRpc\Services;

class Response extends EmptyResponse
{
    const PARSE_ERROR = -32700;
    const INVALID_ARGUMENTS = -32602;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_REQUEST = -32600;
    const INTERNAL_ERROR = -32603;
    const SUCCESS = 200;

    private $id;
    private $message;
    private $code;
    private $data;
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param string $message
     * @param integer $code
     * @param null|boolean|integer|float|string|array  $data
     */
    public function __construct($id, int $code, $data = null, string $message = '')
    {

        $this->id = $id;
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        // die($this->data);
        $response = [
            'id' => $this->id,
        ];
        if ($this->isError()) {
            $response['error'] = [
                'code' => $this->code,
                'message' => $this->message
            ];
        } else {
            $response['result'] = $this->data;
        }
        // echo $response['result'];
        return $response;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return json_encode($this->asArray());
    }



    /** 
     * @return bool 
    */
    private function isError(): bool
    {
        return $this->code !== 200;
    }
}