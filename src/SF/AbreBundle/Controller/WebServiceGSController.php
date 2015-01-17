<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * WebServiceGS controller.
 * Controlador para un Service de Symfony2 
 * que se conecta al Web Service de Gabinete Social.
 *
 * @Route("/wsgs")
 */
class WebServiceGSController extends Controller
{

	private $clienteSOAP = null;

	private function soapInit() {
		//$options = array('login' => 'gobRE','password' => 'go2dk\'3dk?');
		try {
		  $this->clienteSOAP = new \SoapClient('https://aswe.santafe.gov.ar/proxy.php/DS/gabinete_social?wsdl');
		}
		  catch(Exception $e){
		  	echo "erorr";
		}
	}

	function getEjesTrabajo() {
		$this->soapInit();
		return $this->clienteSOAP->getEjesTrabajo();
	}

	function getLineasDeAccion($ejeTrabajoId) {
		$this->soapInit();
		return $this->clienteSOAP->getLineasAccion($ejeTrabajoId);
	}

	function getIntervenciones($lineaAccionId) {
		$this->soapInit();
		return $this->clienteSOAP->getIntervenciones($lineaAccionId);
	}

	function getBarrios($localidadId) {
		$this->soapInit();
		return $this->clienteSOAP->getBarrios($localidadId);
	}

	function getDistritos($localidadId) {
		$this->soapInit();
		return $this->clienteSOAP->getDistritos($localidadId);
	}

	function getLocalidades() {
		$this->soapInit();
		return $this->clienteSOAP->getLocalidades();	
	}

	function getProyectos($localidadId) {
		$this->soapInit();
		return $this->clienteSOAP->getProyectos($localidadId);
	}

}