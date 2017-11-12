<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 12.11.17
 * Time: 19:19
 */

namespace Sibers\ApiBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['jsonToForm', 255]
            ]
        ];
    }

    public function jsonToForm(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $uri = $request->getUri();
        if(strpos($uri, '/api/login_check') !== false){
            $headers = $request->headers->all();
            $idx = array_search('application/json',$headers['content-type']);
            if($idx !== false){
                $data = json_decode($request->getContent(), true);
                $event->getRequest()->request->replace($data);
                $headers['content-type'][$idx] = 'application/x-www-form-urlencoded';
                $event->getRequest()->headers->replace($headers);

            }

        }
    }

}