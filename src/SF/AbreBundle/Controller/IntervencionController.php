<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\Intervencion;
use SF\AbreBundle\Form\IntervencionType;

/**
 * Intervencion controller.
 *
 * @Route("/admin/intervencion")
 */
class IntervencionController extends Controller
{

    /**
     * Lists all Intervencion entities.
     *
     * @Route("/", name="intervencion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:Intervencion')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar intervenciones desde el webservice
     *
     * @Route("/importar", name="intervencion_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Vacía la tabla de Intervenciones
        $cmd = $em->getClassMetadata("SFAbreBundle:Intervencion");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        // Bucle por las lineas de acción del WebService
        $lineasAccion = $em->getRepository('SFAbreBundle:LineaAccion')->findAll();

        foreach($lineasAccion as $lineaAccion) {

            $intervenciones = $this->container->get("sfabre.wsgs")->getIntervenciones($lineaAccion->getId());

            if(!empty($intervenciones)) {

                foreach($intervenciones->item as $intervencion) {

                    if (is_object($intervencion)) {

                        $intervencionModelo = new Intervencion();
                        $intervencionModelo->setId($intervencion->int_id);
                        $intervencionModelo->setNombre($intervencion->int_nombre);
                        $intervencionModelo->setOrden($intervencion->int_nro_orden);

                        $intervencionModelo->setLineaAccion($lineaAccion);
                        $em->persist($intervencionModelo);

                    }
                }

            }

        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('intervencion'));

    }

    /**
     * Creates a new Intervencion entity.
     *
     * @Route("/", name="intervencion_create")
     * @Method("POST")
     * @Template("SFAbreBundle:Intervencion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Intervencion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('intervencion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Intervencion entity.
     *
     * @param Intervencion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Intervencion $entity)
    {
        $form = $this->createForm(new IntervencionType(), $entity, array(
            'action' => $this->generateUrl('intervencion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Intervencion entity.
     *
     * @Route("/new", name="intervencion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Intervencion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Intervencion entity.
     *
     * @Route("/{id}", name="intervencion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Intervencion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intervencion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Intervencion entity.
     *
     * @Route("/{id}/edit", name="intervencion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Intervencion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intervencion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Intervencion entity.
    *
    * @param Intervencion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Intervencion $entity)
    {
        $form = $this->createForm(new IntervencionType(), $entity, array(
            'action' => $this->generateUrl('intervencion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Intervencion entity.
     *
     * @Route("/{id}", name="intervencion_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:Intervencion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Intervencion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intervencion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('intervencion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Intervencion entity.
     *
     * @Route("/{id}", name="intervencion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:Intervencion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Intervencion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('intervencion'));
    }

    /**
     * Creates a form to delete a Intervencion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('intervencion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
