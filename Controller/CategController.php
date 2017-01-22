<?php

namespace DidUngar\ApiBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategController extends AbstractController
{
    /**
     * @Route("/categ.json")
     * @Template()
     */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$repCateg = $em->getRepository('DidUngarBlogBundle:Categ');
	$lstCateg = $repCateg->findBy([]);
	foreach($lstCateg as $key => $oCateg) {
		$lstCateg[$key] = [
			'id'=>$oCateg->getId(),
			'slug'=>$oCateg->getSlug(),
			'name'=>$oCateg->getTitle(),
			'order_cols'=>$oCateg->getOrderCols(),
			'order_sens'=>$oCateg->getOrderSens(),
		];
	}

        return $this->response($lstCateg);
    }
}
