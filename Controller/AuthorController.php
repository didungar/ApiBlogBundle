<?php

namespace DidUngar\ApiBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author.json")
     * @Template()
     */
    public function lstAuthorAction()
    {
	$em = $this->getDoctrine()->getManager();
	$repAuthors = $em->getRepository('DidUngarBlogBundle:Author');
	$lstAuthor = $repAuthors->findBy([]);
	foreach($lstAuthor as $key => $oAuthor) {
		$lstAuthor[$key] = [
			'id'=>$oAuthor->getId(),
			'name'=>$oAuthor->getName(),
		];
	}

        return $this->response($lstAuthor);
    }
    /**
     * @Route("/author/{id_author}.json")
     * @Template()
     */
    public function getAuthorAction($id_author)
    {
	$em = $this->getDoctrine()->getManager();
	$repAuthors = $em->getRepository('DidUngarBlogBundle:Author');
	$oAuthor = $repAuthors->find($id_author);

        return $this->response([
		'id'=>$oAuthor->getId(),
		'name'=>$oAuthor->getName(),
	]);
    }
}
