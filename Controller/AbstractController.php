<?php

/*
 * All API's controllers need extend this class.
 */
 
namespace DidUngar\ApiBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Shootthem\ApiBundle\Entity\Logs;
use Symfony\Component\HttpFoundation\Request;
 
abstract class AbstractController extends Controller {
 	protected $app;
	protected $auth;

	public function checkIsset(array $aLst = []) {
		if ( empty($aLst) ) {
			throw new \Exception('aLst required empty');
		}
		foreach($aLst as $required) {
			if ( !isset($_POST[$required]) ) {
				throw new \Exception($required. ' required');
			}
		}
		return true;
	}

	public function checkRequired(array $aLst = []) {
		if ( empty($aLst) ) {
			throw new \Exception('aLst required empty');
		}
		foreach($aLst as $required) {
			if ( empty($_POST[$required]) ) {
				throw new \Exception($required. ' required');
			}
		}
		return true;
	}

	public function checkNumeric(array $aLst = []) {
		if ( empty($aLst) ) {
			throw new \Exception('aLst required empty');
		}
		$this->checkIsset($aLst);
		foreach($aLst as $required) {
			if ( !is_numeric($_POST[$required]) ) {
				throw new \Exception($required. ' not numeric');
			}
		}
		return true;
	}

	public function checkPositif(array $aLst = []) {
		if ( empty($aLst) ) {
			throw new \Exception('aLst required empty');
		}
		$this->checkRequired($aLst);
		$this->checkNumeric($aLst);
		foreach($aLst as $required) {
			if ( $_POST[$required]<=0 ) {
				throw new \Exception($required. ' not positif');
			}
		}
		return true;
	}

	protected function makeAllow(){
		$request = Request::createFromGlobals();
		$request->headers->set('Access-Control-Allow-Origin:', '*');
		$request->headers->set('Access-Control-Allow-Methods:', 'GET, POST');
		$request->headers->set('Access-Control-Allow-Headers:', 'Content-Type');
	}
	
	protected function response(Array $data, $error=false) {
		$request = Request::createFromGlobals();
		// Mise en forme :
		$aRet = [
			'error' => $error,
			'response' => $data,
		];
		// Logs :
		$oLog = new \Shootthem\ApiBundle\Entity\Logs();
		$oLog->setQuandIni(new \DateTime());
		$oLog->setQuandEnd(new \DateTime());
		$oLog->setREMOTEADDR(empty($_SERVER['REMOTE_ADDR'])?'':$_SERVER['REMOTE_ADDR']);
		$oLog->setREQUESTURI($request->getUri());
		$oLog->setPost(json_encode($_POST));
		$oLog->setResult(json_encode($aRet));
		$em = $this->getDoctrine()->getManager();
		$em->persist($oLog);
		$em->flush();
		// Retour :
		return new JsonResponse($aRet);
	}
	
	protected function errorResponse(/*string*/$msg='',/*integer*/$code_error=-1) {
		$request = Request::createFromGlobals();
		// Mise en forme :
		$aRet = ['error' => true, 'response'=> (object)[], 'message'=> $msg, 'code_error'=>$code_error];
		// Logs :
		$oLog = new \Shootthem\ApiBundle\Entity\Logs();
		$oLog->setQuandIni(new \DateTime());
		$oLog->setQuandEnd(new \DateTime());
		$oLog->setREMOTEADDR(empty($_SERVER['REMOTE_ADDR'])?'':$_SERVER['REMOTE_ADDR']);
		$oLog->setREQUESTURI($request->getUri());
		$oLog->setPost(json_encode($_POST));
		$oLog->setResult(json_encode($aRet));
		$em = $this->getDoctrine()->getManager();
		$em->persist($oLog);
		$em->flush();
		// Retour :
		return new JsonResponse($aRet);
	}
}

