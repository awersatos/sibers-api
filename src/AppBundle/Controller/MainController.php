<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/{er}")
     */
    public function indexAction($er = null)
    {
        $errorHandler = $this->container->get('sibers_api.error_handler');

        if ($er == 'error') {
            $errorHandler->createError(401, 999, 'Internal', 'Sibers API error');
        }
        return $this->render('AppBundle:Main:index.html.twig', array());
    }

}
