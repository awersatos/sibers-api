<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 19.11.17
 * Time: 1:28
 */

namespace Sibers\ApiBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $errorHandler;

    /**
     * ResponseEventListener constructor.
     */
    public function __construct($errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (strpos($event->getRequest()->getPathInfo(), '/api') !== 0) {
            return;
        }

        $e = $event->getException();
        $message = $e->getMessage();
        $code = $e->getCode();

        $result['status'] = 'error';
        $result['errors'][] = [
            'code' => $code,
            'name' => $message,
            'description' => 'Internal error'
        ];

        $response = new Response();
        $response->setContent(json_encode($result))->setStatusCode(404);
        $response->headers->set('Content-Type', 'application/json');
        $event->setResponse($response);
    }
}