<?php

namespace Saraceno\JsonRpc\Services;
include("Response.php");
include("exceptions/MethodException.php");

use GuzzleHttp\Exception\ServerException;
use Saraceno\JsonRpc\Exceptions\MethodException;
use Saraceno\JsonRpc\Services\Request;
use Saraceno\JsonRpc\Services\Response;
use Saraceno\JsonRpc\Services\EmptyResponse;

class JsonRpcServer 
{
    /**
     * @var mixed
     */
    private $SubjectClass;

    public function __construct($subject)
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
        }

        return new Response($Request->getId(), Response::SUCCESS, $result);

                // } catch (TooManyParameters $Exception) {
        //     return ErrorResponse::invalidParameters($Request->getId(), 'Too many parameters');
        // } catch (InvalidParameter $Exception) {
        //     return ErrorResponse::invalidParameters($Request->getId(), $Exception->getMessage() ?: null);
        // } catch (MissingParameter $Exception) {
        //     return ErrorResponse::invalidParameters($Request->getId(), $Exception->getMessage() ?: null);
        // }
    }

    /**
     * @param Request $Request
     * @return EmptyResponse
     */
    private function handleNotification(Request $Request)
    {
        try {
            $this->SubjectClass->invoke($Request);
        } catch (ServerException $Exception) {
            // Do not report errors on notifications
        }

        return new EmptyResponse();
    }
}


?>