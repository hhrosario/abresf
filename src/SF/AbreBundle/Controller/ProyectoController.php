<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\Proyecto;
use SF\AbreBundle\Entity\DatoGeografico;
use SF\AbreBundle\Entity\DetalleProyecto;
use SF\AbreBundle\Entity\EstadoProyecto;
use SF\AbreBundle\Form\ProyectoType;

/**
 * Proyecto controller.
 *
 * @Route("/admin/proyecto")
 */
class ProyectoController extends Controller
{

    /**
     * Lists all Proyecto entities.
     *
     * @Route("/", name="proyecto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $localidades = $em->getRepository('SFAbreBundle:Localidad')->findAll();
        $ejesTrabajo = $em->getRepository('SFAbreBundle:EjeTrabajo')->findAll();

        ini_set("memory_limit", "512M");

        //$entities = $em->getRepository('SFAbreBundle:Proyecto')->findBy(array(), array('leido' => 'DESC', 'fecha' => 'DESC'));

        $joins = array();
        $condiciones = array();

        $joins[] = " JOIN p.localidad lo";
        $joins[] = " JOIN p.intervencion i";
        $joins[] = " LEFT JOIN p.dato_geografico d";
        
        if ($request->get('linea_accion')) {
            $joins[] = " JOIN p.linea_accion li";
            $condiciones[] = "p.linea_accion = :linea_accion";
        }
        if ($request->get('intervencion')) {
            $condiciones[] = "p.intervencion = :intervencion";
        }
        if ($request->get('eje_trabajo')) {
            $joins[] = " JOIN p.eje_trabajo e";
            $condiciones[] = "p.eje_trabajo = :eje_trabajo";
        }
        if ($request->get('localidad')) {
            $condiciones[] = "p.localidad = :localidad";
        }

        if ($request->get('nombre')) {
            $condiciones[] = "p.nombre LIKE :nombre";
        }
        
        $dql = "SELECT p, lo, i, d FROM SFAbreBundle:Proyecto p";

        if (!empty($joins)) {
            $dql .= implode($joins, " ");
        }

        if (!empty($condiciones)) {
            $dql .= " WHERE ";
            $dql .= implode($condiciones, " AND ");
        }

        $dql .= " ORDER BY p.leido DESC, p.fecha DESC";
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
        if ($request->get('nombre')) {
            $query->setParameter("nombre", '%'.$request->get('nombre').'%');
        }

        $entities = $query->getArrayResult();

        return array(
            'entities' => $entities,
            'localidades' => $localidades,
            'ejes_trabajo' => $ejesTrabajo
        );
    }
    /**
     * Creates a new Proyecto entity.
     *
     * @Route("/", name="proyecto_create")
     * @Method("POST")
     * @Template("SFAbreBundle:Proyecto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Proyecto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('proyecto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Proyecto entity.
     *
     * @param Proyecto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Proyecto $entity)
    {
        $form = $this->createForm(new ProyectoType(), $entity, array(
            'action' => $this->generateUrl('proyecto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Proyecto entity.
     *
     * @Route("/new", name="proyecto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Proyecto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Proyecto entity.
     *
     * @Route("/{id}", name="proyecto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Proyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Proyecto entity.
     *
     * @Route("/{id}/edit", name="proyecto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Proyecto')->find($id);

        $detalles = $em->getRepository('SFAbreBundle:DetalleProyecto')->findByProyecto($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proyecto entity.');
        }

        if ($entity->getImagen()) {
          $imagenUrl = $entity->getImagen()->getWebPath();
        } else {
          $imagenUrl = null;
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'detalles'      => $detalles,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'imagenUrl' => $imagenUrl,
        );
    }

    /**
    * Creates a form to edit a Proyecto entity.
    *
    * @param Proyecto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Proyecto $entity)
    {
        $form = $this->createForm(new ProyectoType(), $entity, array(
            'action' => $this->generateUrl('proyecto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Proyecto entity.
     *
     * @Route("/{id}", name="proyecto_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:Proyecto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Proyecto')->find($id);

        if ($entity->getImagen()) {
          $imagenUrl = $entity->getImagen()->getWebPath();
        } else {
          $imagenUrl = null;
        }

        $detalles = $em->getRepository('SFAbreBundle:DetalleProyecto')->findByProyecto($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $imagen = $entity->getImagen();
            if ($imagen) {
                $imagen->setRootDir($this->get('kernel')->getRootDir() . '/..');
                $imagen->preUpload();
            }
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('proyecto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'detalles'    => $detalles,
            'delete_form' => $deleteForm->createView(),
            'imagenUrl' => $imagenUrl,
        );
    }
    /**
     * Deletes a Proyecto entity.
     *
     * @Route("/{id}", name="proyecto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:Proyecto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proyecto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proyecto'));
    }

    /**
     * Creates a form to delete a Proyecto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyecto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

/******************
*
**********************************************/

    /**
     * Importar intervenciones desde el webservice
     *
     * @Route("/importar/", name="proyecto_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {

        set_time_limit(300);

        $em = $this->getDoctrine()->getManager();

        $cmd = $em->getClassMetadata("SFAbreBundle:Proyecto");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $cmd = $em->getClassMetadata("SFAbreBundle:DetalleProyecto");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');


        $cmd = $em->getClassMetadata("SFAbreBundle:EstadoProyecto");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $cmd = $em->getClassMetadata("SFAbreBundle:DatoGeografico");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');


        // Bucle por las lineas de acción del WebService
        $localidades = $em->getRepository('SFAbreBundle:Localidad')->findAll();

        $cuentaProyectos = 0;

        foreach($localidades as $localidad) {

            $proyectos = $this->container->get("sfabre.wsgs")->getProyectos($localidad->getId());

            if(!empty($proyectos)) {

                foreach($proyectos->item as $proyecto) {
                    $proyectoModelo = new Proyecto();
                    $proyectoModelo->setId($proyecto->pro_id);
                    $proyectoModelo->setNombre($proyecto->pro_nombre);
                    $proyectoModelo->setOrden($proyecto->pro_nro_orden);
                    $proyectoModelo->setObservacion($proyecto->pro_observacion);

                    // Copia los datos básicos a los campos públicos
                    $proyectoModelo->setTituloPublico($proyecto->pro_nombre);

                    $date = new \DateTime($proyecto->pro_fecha->date, new \DateTimeZone($proyecto->pro_fecha->timezone));
                    $proyectoModelo->setFecha($date);

                    $lineaAccion = $em->getRepository('SFAbreBundle:LineaAccion')->find($proyecto->linea_accion->lac_id);
                    $intervencion = $em->getRepository('SFAbreBundle:Intervencion')->find($proyecto->intervencion->int_id);
                    $ejeTrabajo = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($proyecto->ejes_trabajo->etr_id);

                    if (isset($proyecto->dato_geografico)) {
                        $datoGeografico = new DatoGeografico();
                        $datoGeografico->setGeoId($proyecto->dato_geografico->pge_geo_id);
                        $datoGeografico->setGeoChar($proyecto->dato_geografico->pge_geo_char);
                        $datoGeografico->setDescripcion($proyecto->dato_geografico->pge_descripcion);
                        $proyectoModelo->setDatoGeografico($datoGeografico);
                    }

                    $proyectoModelo->setLineaAccion($lineaAccion);
                    $proyectoModelo->setIntervencion($intervencion);
                    $proyectoModelo->setEjeTrabajo($ejeTrabajo);
                    $proyectoModelo->setLocalidad($localidad);

                    $detallesModelo = array();
                    foreach ($proyecto->detalles->item as $detalleProyecto) {

                        if (isset($detalleProyecto->pde_id)) {

                            $detalleProyectoModelo = new DetalleProyecto();
                            $detalleProyectoModelo->setId($detalleProyecto->pde_id);
                            $detalleProyectoModelo->setNombre($detalleProyecto->pde_nombre);
                            $detalleProyectoModelo->setOrden(@$detalleProyecto->pde_orden);
                            $detalleProyectoModelo->setMonto($detalleProyecto->pde_monto_inversion);

                            $estadoProyecto = new EstadoProyecto();
                            $estadoProyecto->setPesId($detalleProyecto->estado->pes_id);
                            $estadoProyecto->setNombre($detalleProyecto->estado->pes_nombre);
                            $detalleProyectoModelo->setEstado($estadoProyecto);

                            $date = new \DateTime($detalleProyecto->pde_fecha->date, new \DateTimeZone($detalleProyecto->pde_fecha->timezone));
                            $detalleProyectoModelo->setFecha($date);

                            $date = new \DateTime($detalleProyecto->pde_plazo_desde->date, new \DateTimeZone($detalleProyecto->pde_plazo_desde->timezone));
                            $detalleProyectoModelo->setPlazoDesde($date);

                            $date = new \DateTime($detalleProyecto->pde_plazo_hasta->date, new \DateTimeZone($detalleProyecto->pde_plazo_hasta->timezone));
                            $detalleProyectoModelo->setPlazoHasta($date);

                            $detalleProyectoModelo->setProyecto($proyectoModelo);

                            $proyectoModelo->addDetalle($detalleProyectoModelo);

                        }
                    }

                    $em->persist($proyectoModelo);
                    $em->flush();
                    $cuentaProyectos++;

                    // FIXME: Quitar este límite arbitrario
                    /*if ($cuentaProyectos > 300) {
                        return $this->redirect($this->generateUrl('proyecto'));
                    }*/
                }

            }

        }
        
        return $this->redirect($this->generateUrl('proyecto'));

    }


}
