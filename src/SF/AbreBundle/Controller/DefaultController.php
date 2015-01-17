<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\EjeTrabajo;
use SF\AbreBundle\Entity\LineaAccion;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $localidades = $em->getRepository('SFAbreBundle:Localidad')->findAll();
        $ejesTrabajo = $em->getRepository('SFAbreBundle:EjeTrabajo')->findAll();
        $lineasDeAccion = $em->getRepository('SFAbreBundle:LineaAccion')->findAll();
        $barriosRosario = $em->getRepository('SFAbreBundle:Barrio')->findByLocalidad(212);
        $distritosRosario = $em->getRepository('SFAbreBundle:Distrito')->findByLocalidad(212);
        $barriosSantaFe = $em->getRepository('SFAbreBundle:Barrio')->findByLocalidad(150);
        $distritosSantaFe = $em->getRepository('SFAbreBundle:Distrito')->findByLocalidad(150);
        $barriosVGG = $em->getRepository('SFAbreBundle:Barrio')->findByLocalidad(213);
        $distritosVGG = $em->getRepository('SFAbreBundle:Distrito')->findByLocalidad(213);
        $barriosSantoTome = $em->getRepository('SFAbreBundle:Barrio')->findByLocalidad(151);
        $distritosSantoTome = $em->getRepository('SFAbreBundle:Distrito')->findByLocalidad(151);

        return array(
            'ejes' => $ejesTrabajo,
            'lineas' => $lineasDeAccion,
            'barrios_rosario' => $barriosRosario,
            'distritos_rosario' => $distritosRosario,
            'barrios_santafe' => $barriosSantaFe,
            'distritos_santafe' => $distritosSantaFe,
            'barrios_vgg' => $barriosVGG,
            'distritos_vgg' => $distritosVGG,
            'barrios_santotome' => $barriosSantoTome,
            'distritos_santotome' => $distritosSantoTome,
            'localidades' => $localidades
        );
    }

    /**
     * Obtiene todas las intervenciones por línea de acción
     *
     * @Route("/lineas/poreje/{id}", name="linea_poreje")
     * @Method("GET")
     */
    public function porejeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $lineaDeAccion = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($id);

        $dql = "SELECT li FROM SFAbreBundle:LineaAccion li JOIN li.eje_trabajo e WHERE li.eje_trabajo = ?1";
        $query = $em->createQuery($dql);
        $query->setParameter(1, $id);
        $entities = $query->getArrayResult();

        $response = new Response(
            json_encode(
                $entities
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * Obtiene todas las intervenciones por línea de acción
     *
     * @Route("/intervencion/porlinea/{id}", name="intervencion_porlinea")
     * @Method("GET")
     */
    public function porlineaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $lineaDeAccion = $em->getRepository('SFAbreBundle:LineaAccion')->find($id);

        $dql = "SELECT i FROM SFAbreBundle:Intervencion i JOIN i.linea_accion l WHERE i.linea_accion = ?1";
        $query = $em->createQuery($dql);
        $query->setParameter(1, $id);
        $entities = $query->getArrayResult();

        $response = new Response(
        	json_encode(
        		$entities
        	)
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * Obtiene todas las intervenciones por línea de acción
     *
     * @Route("/barrios/{id}", name="barrios")
     * @Method("GET")
     */
    public function barriosAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $lineaDeAccion = $em->getRepository('SFAbreBundle:Localidad')->find($id);

        $dql = "SELECT b FROM SFAbreBundle:Barrio b JOIN b.localidad l WHERE b.localidad = ?1 ORDER BY b.nombre";
        $query = $em->createQuery($dql);
        $query->setParameter(1, $id);
        $entities = $query->getArrayResult();

        $response = new Response(
            json_encode(
                $entities
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * Obtiene todas las intervenciones por línea de acción
     *
     * @Route("/distritos/{id}", name="distritos")
     * @Method("GET")
     */
    public function distritosAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $lineaDeAccion = $em->getRepository('SFAbreBundle:Localidad')->find($id);

        $dql = "SELECT d FROM SFAbreBundle:Distrito d JOIN d.localidad l WHERE d.localidad = ?1 ORDER BY d.nombre";
        $query = $em->createQuery($dql);
        $query->setParameter(1, $id);
        $entities = $query->getArrayResult();

        $response = new Response(
            json_encode(
                $entities
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Obtiene los proyectos según los filtros
     *
     * @Route("/obtenerProyectos", name="obtener_proyectos")
     * @Method("POST")
     */
    public function obtenerProyectosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $joins = array();
        $condiciones = array();

        if ($request->get('linea_accion')) {
            $joins[] = " JOIN p.linea_accion li";
            $condiciones[] = "p.linea_accion = :linea_accion";
        }
        if ($request->get('intervencion')) {
            $joins[] = " JOIN p.intervencion i";
            $condiciones[] = "p.intervencion = :intervencion";
        }
        if ($request->get('eje_trabajo')) {
            $joins[] = " JOIN p.eje_trabajo e";
            $condiciones[] = "p.eje_trabajo = :eje_trabajo";
        }
        if ($request->get('localidad')) {
            $joins[] = " JOIN p.localidad lo";
            $condiciones[] = "p.localidad = :localidad";
        }

        $dql = "SELECT p FROM SFAbreBundle:Proyecto p";

        if (!empty($joins) && !empty($condiciones)) {
            $dql .= implode($joins, " ");
            $dql .= " WHERE ";
            $dql .= implode($condiciones, " AND ");
        }

        $dql .= " ORDER BY p.nombre";
       
        $query = $em->createQuery($dql);
        if ($request->get('linea_accion')) {
            $query->setParameter("linea_accion", $request->get('linea_accion'));
        }
        if ($request->get('intervencion')) {
            $query->setParameter("intervencion", $request->get('intervencion'));
        }
        if ($request->get('eje_trabajo')) {
            $query->setParameter("eje_trabajo", $request->get('eje_trabajo'));
        }
        if ($request->get('localidad')) {
            $query->setParameter("localidad", $request->get('localidad'));
        }

        $entities = $query->getArrayResult();

        $response = new Response(
            json_encode(
                $entities
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Obtiene todas las intervenciones por línea de acción
     *
     * @Route("/proyecto/{id}", name="obtener_proyecto")
     * @Method("GET")
     */
    public function obtenerProyectoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT p, e, lo, li, i FROM SFAbreBundle:Proyecto p 
         LEFT JOIN p.eje_trabajo e 
         LEFT JOIN p.localidad lo 
         LEFT JOIN p.intervencion i 
         LEFT JOIN p.linea_accion li 
         WHERE p.id = :id")
                    ->setParameter('id', $id);
        $proyecto = $query->getArrayResult();

        $proyectoObjeto = $em->getRepository('SFAbreBundle:Proyecto')->find($id);

        if ($proyectoObjeto->getImagen()) {
            $proyecto[0]['imagen'] = $proyectoObjeto->getImagen()->getWebPath();
        } else {
            $proyecto[0]['imagen'] = '';
        }

        $response = new Response(
            json_encode(
                $proyecto
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
