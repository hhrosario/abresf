<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\EstadoProyecto;
use SF\AbreBundle\Form\EstadoProyectoType;

/**
 * EstadoProyecto controller.
 *
 * @Route("/admin/estadoproyecto")
 */
class EstadoProyectoController extends Controller
{

    /**
     * Lists all EstadoProyecto entities.
     *
     * @Route("/", name="estadoproyecto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:EstadoProyecto')->findAll();

        print_r($this->container->get("sfabre.wsgs")->getEjesTrabajo());
        die;

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Creates a new EstadoProyecto entity.
     *
     * @Route("/", name="estadoproyecto_create")
     * @Method("POST")
     * @Template("SFAbreBundle:EstadoProyecto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EstadoProyecto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('estadoproyecto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a EstadoProyecto entity.
     *
     * @param EstadoProyecto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EstadoProyecto $entity)
    {
        $form = $this->createForm(new EstadoProyectoType(), $entity, array(
            'action' => $this->generateUrl('estadoproyecto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EstadoProyecto entity.
     *
     * @Route("/new", name="estadoproyecto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EstadoProyecto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EstadoProyecto entity.
     *
     * @Route("/{id}", name="estadoproyecto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EstadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoProyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EstadoProyecto entity.
     *
     * @Route("/{id}/edit", name="estadoproyecto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EstadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoProyecto entity.');
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
    * Creates a form to edit a EstadoProyecto entity.
    *
    * @param EstadoProyecto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadoProyecto $entity)
    {
        $form = $this->createForm(new EstadoProyectoType(), $entity, array(
            'action' => $this->generateUrl('estadoproyecto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EstadoProyecto entity.
     *
     * @Route("/{id}", name="estadoproyecto_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:EstadoProyecto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:EstadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoProyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('estadoproyecto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EstadoProyecto entity.
     *
     * @Route("/{id}", name="estadoproyecto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:EstadoProyecto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadoProyecto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadoproyecto'));
    }

    /**
     * Deletes a EstadoProyecto entity.
     *
     * @Route("/{id}", name="estadoproyecto_jdelete")
     * @Method("DELETE")
     */
    public function ajaxDeleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:EstadoProyecto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadoProyecto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadoproyecto'));
    }


    /**
     * Creates a form to delete a EstadoProyecto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadoproyecto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
