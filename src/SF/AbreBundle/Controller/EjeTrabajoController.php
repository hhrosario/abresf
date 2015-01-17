<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\EjeTrabajo;
use SF\AbreBundle\Form\EjeTrabajoType;

/**
 * EjeTrabajo controller.
 *
 * @Route("/admin/ejetrabajo")
 */
class EjeTrabajoController extends Controller
{

    /**
     * Lists all EjeTrabajo entities.
     *
     * @Route("/", name="ejetrabajo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:EjeTrabajo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar ejes de trabajo desde el webservice
     *
     * @Route("/importar", name="ejetrabajo_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cmd = $em->getClassMetadata("SFAbreBundle:EjeTrabajo");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $ejesTrabajo = $this->container->get("sfabre.wsgs")->getEjesTrabajo();

        foreach($ejesTrabajo->item as $ejeTrabajo) {
            $eje = new EjeTrabajo();
            $eje->setId($ejeTrabajo->etr_id);
            $eje->setNombre($ejeTrabajo->etr_nombre);
            $eje->setOrden($ejeTrabajo->etr_nro_orden);
            $em->persist($eje);
        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('ejetrabajo'));

    }

    /**
     * Creates a new EjeTrabajo entity.
     *
     * @Route("/", name="ejetrabajo_create")
     * @Method("POST")
     * @Template("SFAbreBundle:EjeTrabajo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EjeTrabajo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ejetrabajo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a EjeTrabajo entity.
     *
     * @param EjeTrabajo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EjeTrabajo $entity)
    {
        $form = $this->createForm(new EjeTrabajoType(), $entity, array(
            'action' => $this->generateUrl('ejetrabajo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EjeTrabajo entity.
     *
     * @Route("/new", name="ejetrabajo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EjeTrabajo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EjeTrabajo entity.
     *
     * @Route("/{id}", name="ejetrabajo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EjeTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EjeTrabajo entity.
     *
     * @Route("/{id}/edit", name="ejetrabajo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EjeTrabajo entity.');
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
    * Creates a form to edit a EjeTrabajo entity.
    *
    * @param EjeTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EjeTrabajo $entity)
    {
        $form = $this->createForm(new EjeTrabajoType(), $entity, array(
            'action' => $this->generateUrl('ejetrabajo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EjeTrabajo entity.
     *
     * @Route("/{id}", name="ejetrabajo_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:EjeTrabajo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EjeTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ejetrabajo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EjeTrabajo entity.
     *
     * @Route("/{id}", name="ejetrabajo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:EjeTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EjeTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ejetrabajo'));
    }

    /**
     * Creates a form to delete a EjeTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ejetrabajo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
