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
use Sibers\ApiBundle\Exceptions\SibersApiException;

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

        if($e instanceof SibersApiException){
            $event->setResponse($e->getResponce());
            return;
        }

        $message = $e->getMessage();
        $code = $e->getCode();
        $status = $e->getStatusCode();
        $trace = $e->getTraceAsString();

        $event->setResponse($this->errorHandler->getResponse($status, $code, $message, $trace));
    }
}