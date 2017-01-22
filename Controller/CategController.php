<?php

namespace DidUngar\ApiBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
* @Route("/categ")
*/
class CategController extends AbstractController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->response([
		
	]);
    }
}
