<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\LineaAccion;
use SF\AbreBundle\Form\LineaAccionType;

/**
 * LineaAccion controller.
 *
 * @Route("/admin/lineaaccion")
 */
class LineaAccionController extends Controller
{

    /**
     * Lists all LineaAccion entities.
     *
     * @Route("/", name="lineaaccion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:LineaAccion')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar ejes de trabajo desde el webservice
     *
     * @Route("/importar", name="lineaaccion_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cmd = $em->getClassMetadata("SFAbreBundle:LineaAccion");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $ejesDeTrabajo = $em->getRepository('SFAbreBundle:EjeTrabajo')->findAll();

        foreach($ejesDeTrabajo as $ejeDeTrabajo) {

            $lineasDeAccion = $this->container->get("sfabre.wsgs")->getLineasDeAccion($ejeDeTrabajo->getId());

            foreach($lineasDeAccion->item as $lineaAccion) {
                $linea = new LineaAccion();
                $linea->setId($lineaAccion->lac_id);
                $linea->setNombre($lineaAccion->lac_nombre);
                $linea->setOrden($lineaAccion->lac_nro_orden);
                $linea->setEjeTrabajo($ejeDeTrabajo);
                $em->persist($linea);
            }

        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('lineaaccion'));

    }

    /**
     * Creates a new LineaAccion entity.
     *
     * @Route("/", name="lineaaccion_create")
     * @Method("POST")
     * @Template("SFAbreBundle:LineaAccion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new LineaAccion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lineaaccion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a LineaAccion entity.
     *
     * @param LineaAccion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(LineaAccion $entity)
    {
        $form = $this->createForm(new LineaAccionType(), $entity, array(
            'action' => $this->generateUrl('lineaaccion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new LineaAccion entity.
     *
     * @Route("/new", name="lineaaccion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LineaAccion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LineaAccion entity.
     *
     * @Route("/{id}", name="lineaaccion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:LineaAccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineaAccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LineaAccion entity.
     *
     * @Route("/{id}/edit", name="lineaaccion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:LineaAccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineaAccion entity.');
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
    * Creates a form to edit a LineaAccion entity.
    *
    * @param LineaAccion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LineaAccion $entity)
    {
        $form = $this->createForm(new LineaAccionType(), $entity, array(
            'action' => $this->generateUrl('lineaaccion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing LineaAccion entity.
     *
     * @Route("/{id}", name="lineaaccion_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:LineaAccion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:LineaAccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineaAccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lineaaccion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a LineaAccion entity.
     *
     * @Route("/{id}", name="lineaaccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:LineaAccion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LineaAccion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lineaaccion'));
    }

    /**
     * Creates a form to delete a LineaAccion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lineaaccion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
