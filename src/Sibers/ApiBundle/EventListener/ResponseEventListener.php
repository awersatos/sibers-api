<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 05.11.17
 * Time: 17:29
 */

namespace Sibers\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseEventListener
{

    private $errorHandler;

    /**
     * ResponseEventListener constructor.
     */
    public function __construct($errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $decoded = json_decode($event->getResponse()->getContent(), true);

        if (!$decoded || !count($decoded)) {
            return;
        }


       // $result['status'] = 'error';
        if (
            $event->getResponse()->getStatusCode() === Response::HTTP_OK
            || $event->getResponse()->getStatusCode() === Response::HTTP_CREATED
        )
        {
            $result['status'] = 'success';
            $result['response'] = $decoded;
            $event->getResponse()->setContent(json_encode($result));
        }/* else {
            foreach ($decoded['hydra:member'] as $value) {
                $result['errors'][] = $value;
            }
        }*/


    }
}