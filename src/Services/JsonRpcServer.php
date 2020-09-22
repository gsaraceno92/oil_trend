<?php

namespace Saraceno\JsonRpc\Services;

use Exception;
use Saraceno\JsonRpc\Services\Request;
use Saraceno\JsonRpc\Services\Response;
use Saraceno\JsonRpc\Services\EmptyResponse;
use Saraceno\JsonRpc\Controllers\TrendManager;
use Saraceno\JsonRpc\Exceptions\MethodException;
use Saraceno\JsonRpc\Exceptions\InvalidArgumentException;

class JsonRpcServer 
{
    /**
     * @var mixed
     */
    private TrendManager $SubjectClass;

    public function __construct(TrendManager $subject)
    {
        $this->SubjectClass = $subject;
    }
    /**
     * @param Request $Request
     * @return Response
     */
    public function handleRequest(Request $Request)
    {
        if (is_null($Request->getId())) {
            return $this->handleNotification($Request);
        }
        try {
            $result = $this->SubjectClass->invoke($Request);
        } catch (MethodException $Exception) {
            return new Response($Request->getId(), Response::METHOD_NOT_FOUND, [], $Exception->getMessage());
        } catch (InvalidArgumentException $Exception) {
            return new Response($Request->getId(), Response::INVALID_ARGUMENTS, [], $Exception->getMessage());
        }
        return new Response($Request->getId(), Response::SUCCESS, $result);

    }

    /**
     * @param Request $Request
     * @return EmptyResponse
     */
    private function handleNotification(Request $Request)
    {
        try {
            $this->SubjectClass->invoke($Request);
        } catch (Exception $Exception) {
            // Do not report errors on notifications
        }

        return new EmptyResponse();
    }
}


?>