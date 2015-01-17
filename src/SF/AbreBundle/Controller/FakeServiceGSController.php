<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * FakeServiceGS controller.
 * Controlador simulado para un Service de Symfony2 
 * que devuelve datos con la misma estructura que 
 * el Web Service de Gabinete Social.
 * 
 * Podrían haber sido en JSON y convertirlo después a objetos,
 * pero para fines prácticos asi también está legible.
 *
 * @Route("/fsgs")
 */
class FakeServiceGSController extends Controller
{

	function getEjesTrabajo() {

		$ejes = new \stdClass();
		$ejes->item = array();

		$ejeTrabajo = new \stdClass();
		$ejeTrabajo->etr_id = 1;
		$ejeTrabajo->etr_nombre = "Infraestructura y habitat";
		$ejeTrabajo->etr_nro_orden = 1;
		$ejes->item[] = $ejeTrabajo;

		$ejeTrabajo = new \stdClass();
		$ejeTrabajo->etr_id = 2;
		$ejeTrabajo->etr_nombre = "Convivencia y participación";
		$ejeTrabajo->etr_nro_orden = 2;
		$ejes->item[] = $ejeTrabajo;

		return $ejes;
	}

	function getLineasDeAccion() {


		$lineas = new \stdClass();
		$lineas->item = array();

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 1;
		$lineaAccion->lac_nombre = "Infraestructuras estrategicas";
		$lineaAccion->lac_nro_orden = 1;
		$lineas->item[] = $lineaAccion;

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 2;
		$lineaAccion->lac_nombre = "Mi Tierra, Mi Casa";
		$lineaAccion->lac_nro_orden = 2;
		$lineas->item[] = $lineaAccion;

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 3;
		$lineaAccion->lac_nombre = "Mejoramiento barrial en complejos de vivienda social";
		$lineaAccion->lac_nro_orden = 3;
		$lineas->item[] = $lineaAccion;

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 4;
		$lineaAccion->lac_nombre = "Proyectos urbanos en asentamientos irregulares";
		$lineaAccion->lac_nro_orden = 4;
		$lineas->item[] = $lineaAccion;

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 5;
		$lineaAccion->lac_nombre = "Saneamiento urbano";
		$lineaAccion->lac_nro_orden = 5;
		$lineas->item[] = $lineaAccion;

		$lineaAccion = new \stdClass();
		$lineaAccion->lac_id = 6;
		$lineaAccion->lac_nombre = "Luz y Agua Segura, para la inclusion social";
		$lineaAccion->lac_nro_orden = 6;
		$lineas->item[] = $lineaAccion;

		return $lineas;

	}

	function getIntervenciones($id) {

		$intervenciones = false;

		if ($id == 1) {

			$intervenciones = new \stdClass();
			$intervenciones->item = array();

			$intervencion = new \stdClass();
			$intervencion->int_id = 1;
			$intervencion->int_nombre = "Mi Tierra, Mi Casa";
			$intervencion->int_nro_orden = 1;
			$intervenciones->item[] = $intervencion;

		}

		return $intervenciones;

	}

	function getLocalidades() {

		$localidades = new \stdClass();

		$localidad = new \stdClass();
		$localidad->loc_id = 212;
		$localidad->loc_nombre = "Rosario";
		$localidad->loc_comu = 863;
		$localidades->item[] = $localidad;

		$localidad = new \stdClass();
		$localidad->loc_id = 150;
		$localidad->loc_nombre = "Santa Fe";
		$localidad->loc_comu = 792;
		$localidades->item[] = $localidad;

		$localidad = new \stdClass();
		$localidad->loc_id = 151;
		$localidad->loc_nombre = "Santo Tome";
		$localidad->loc_comu = 793;
		$localidades->item[] = $localidad;

		$localidad = new \stdClass();
		$localidad->loc_id = 213;
		$localidad->loc_nombre = "Villa Gobernador Galvez";
		$localidad->loc_comu = 864;
		$localidades->item[] = $localidad;

		return $localidades;

	}

	function getBarrios($id) {

		$barrios = false;

		if ($id == 151) {

			$barrios = new \stdClass();
			$barrios->item = array();

			$barrio = new \stdClass();			
			$barrio->bar_id = 34;
			$barrio->bar_nombre = "SANTO TOMAS DE AQUINO";
			$barrio->bar_nro = 1;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 35;
			$barrio->bar_nombre = "Villa LIBERTAD";
			$barrio->bar_nro = 2;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 36;
			$barrio->bar_nombre = "EL CHAPARRAL";
			$barrio->bar_nro = 3;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 37;
			$barrio->bar_nombre = "LOS HORNOS";
			$barrio->bar_nro = 4;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 38;
			$barrio->bar_nombre = "LAS VEGAS";
			$barrio->bar_nro = 5;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 39;
			$barrio->bar_nombre = "12 DE SEPTIEMBRE";
			$barrio->bar_nro = 6;
			$barrios->item[] = $barrio;

			$barrio = new \stdClass();			
			$barrio->bar_id = 40;
			$barrio->bar_nombre = "LAS ADELINAS";
			$barrio->bar_nro = 6;
			$barrios->item[] = $barrio;

		}

		return $barrios;

	}

	function getDistritos($id) {

		$distritos = false;

		if ($id == 151) {

			$distritos = new \stdClass();
			$distritos->item = array();

			$distrito = new \stdClass();			
			$distrito->dis_id = 16;
			$distrito->dis_nombre = "NORTE";
			$distrito->dis_nro = 1;
			$distritos->item[] = $distrito;

			$distrito = new \stdClass();			
			$distrito->dis_id = 17;
			$distrito->dis_nombre = "NOROESTE";
			$distrito->dis_nro = 2;
			$distritos->item[] = $distrito;

			$distrito = new \stdClass();			
			$distrito->dis_id = 18;
			$distrito->dis_nombre = "NORESTE";
			$distrito->dis_nro = 3;
			$distritos->item[] = $distrito;

			$distrito = new \stdClass();			
			$distrito->dis_id = 19;
			$distrito->dis_nombre = "OESTE";
			$distrito->dis_nro = 4;
			$distritos->item[] = $distrito;

			$distrito = new \stdClass();			
			$distrito->dis_id = 20;
			$distrito->dis_nombre = "ESTE";
			$distrito->dis_nro = 5;
			$distritos->item[] = $distrito;

			$distrito = new \stdClass();			
			$distrito->dis_id = 21;
			$distrito->dis_nombre = "SUR";
			$distrito->dis_nro = 6;
			$distritos->item[] = $distrito;

		}

		return $distritos;

	}


	function getProyectos($id) {

		$proyectos = false;

		if ($id == 151) {

			$proyectos = new \stdClass();
			$proyectos->item = array();

			// Datos del proyecto
			$proyecto = new \stdClass();

			$proyecto->pro_id = 151;
			$proyecto->pro_nombre =	"Prueba ST";
			$proyecto->pro_nro_orden = 4;
			$proyecto->pro_observacion = "Observación proyecto 151";

			$proyecto->pro_fecha = new \stdClass();
			$proyecto->pro_fecha->date = "2014-10-03 10:17:03";
			$proyecto->pro_fecha->timezone_type = 3;
			$proyecto->pro_fecha->timezone = "America/Argentina/Buenos_Aires";

			$proyecto->ejes_trabajo = new \stdClass();
			$proyecto->ejes_trabajo->etr_id = 1;
			$proyecto->ejes_trabajo->etr_nombre = "Infraestructura y habitat";
			$proyecto->ejes_trabajo->etr_orden = 1;

			$proyecto->linea_accion = new \stdClass();
			$proyecto->linea_accion->lac_id = 1;
			$proyecto->linea_accion->lac_nombre = "Infraestructuras estrategicas";
			$proyecto->linea_accion->lac_orden = 1;

			$proyecto->intervencion = new \stdClass();
			$proyecto->intervencion->int_id = 1;
			$proyecto->intervencion->int_nombre = "Infraestructura Vial";
			$proyecto->intervencion->int_orden = 1;

			$proyecto->dato_geografico = new \stdClass();
			$proyecto->dato_geografico->pge_descripcion = "";
			$proyecto->dato_geografico->pge_geo_id = 18;
			$proyecto->dato_geografico->pge_geo_char = "18_comisaria_33";

			// Detalles del proyecto
			$proyecto->detalles = new \stdClass();
			$proyecto->detalles->item = array();

			// Detalle individual
			$detalleProyecto = new \stdClass();			
			$detalleProyecto->pde_id = 1;
			$detalleProyecto->pde_nombre = "Infraestructura Vial";
			$detalleProyecto->pde_orden = 1;
			$detalleProyecto->pde_monto_inversion = "43400.00";
			$detalleProyecto->pde_fecha = new \stdClass();
			$detalleProyecto->pde_fecha->date = "2014-10-03 10:17:36";
			$detalleProyecto->pde_fecha->timezone_type = 3;
			$detalleProyecto->pde_fecha->timezone = "America/Argentina/Buenos_Aires";

			$detalleProyecto->pde_plazo_desde = new \stdClass();
			$detalleProyecto->pde_plazo_desde->date = "2014-10-01 00:00:00";
			$detalleProyecto->pde_plazo_desde->timezone_type = 3;
			$detalleProyecto->pde_plazo_desde->timezone = "America/Argentina/Buenos_Aires";

			$detalleProyecto->pde_plazo_hasta = new \stdClass();
			$detalleProyecto->pde_plazo_hasta->date = "2014-10-31 00:00:00";
			$detalleProyecto->pde_plazo_hasta->timezone_type = 3;
			$detalleProyecto->pde_plazo_hasta->timezone = "America/Argentina/Buenos_Aires";

			$detalleProyecto->estado = new \stdClass();
			$detalleProyecto->estado->pes_id = 1;
			$detalleProyecto->estado->pes_nombre = "En ejecución de acuerdo a lo planificado";

			$proyecto->detalles->item[] = $detalleProyecto;

			$proyectos->item[] = $proyecto;

			// Otro proyecto para testing.

		}

		return $proyectos;

	}

}
