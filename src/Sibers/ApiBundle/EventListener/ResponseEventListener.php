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
    /**
     * Sends the Hydra header on each response.
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $decoded = json_decode($event->getResponse()->getContent(), true);

        if (!$decoded || !count($decoded)) {
            return;
        }

       /* if (!array_key_exists('hydra:member', $decoded)) {
            return;
        }*/

        $result['status'] = 'error';
        if (
            $event->getResponse()->getStatusCode() === Response::HTTP_OK
            || $event->getResponse()->getStatusCode() === Response::HTTP_CREATED
        )
        {
            $result['status'] = 'success';
            $result['response'] = $decoded;
           /* foreach ($decoded['hydra:member'] as $value) {
                $result['response'] = $value;
            }*/
        } else {
            foreach ($decoded['hydra:member'] as $value) {
                $result['errors'][] = $value;
            }
        }

        $event->getResponse()->setContent(json_encode($result));
    }
}