<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\Localidad;
use SF\AbreBundle\Form\LocalidadType;

/**
 * Localidad controller.
 *
 * @Route("/admin/localidad")
 */
class LocalidadController extends Controller
{

    /**
     * Lists all Localidad entities.
     *
     * @Route("/", name="localidad")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:Localidad')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar ejes de trabajo desde el webservice
     *
     * @Route("/importar", name="localidad_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cmd = $em->getClassMetadata("SFAbreBundle:Localidad");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $localidades = $this->container->get("sfabre.fsgs")->getLocalidades();

        foreach($localidades->item as $localidad) {
            $localidadModelo = new Localidad();
            $localidadModelo->setId($localidad->loc_id);
            $localidadModelo->setNombre($localidad->loc_nombre);
            $localidadModelo->setComu($localidad->loc_comu);
            $em->persist($localidadModelo);
        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('localidad'));

    }

    /**
     * Creates a new Localidad entity.
     *
     * @Route("/", name="localidad_create")
     * @Method("POST")
     * @Template("SFAbreBundle:Localidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Localidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('localidad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Localidad entity.
     *
     * @param Localidad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Localidad $entity)
    {
        $form = $this->createForm(new LocalidadType(), $entity, array(
            'action' => $this->generateUrl('localidad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Localidad entity.
     *
     * @Route("/new", name="localidad_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Localidad();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Localidad entity.
     *
     * @Route("/{id}", name="localidad_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Localidad entity.
     *
     * @Route("/{id}/edit", name="localidad_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
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
    * Creates a form to edit a Localidad entity.
    *
    * @param Localidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Localidad $entity)
    {
        $form = $this->createForm(new LocalidadType(), $entity, array(
            'action' => $this->generateUrl('localidad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Localidad entity.
     *
     * @Route("/{id}", name="localidad_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:Localidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('localidad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Localidad entity.
     *
     * @Route("/{id}", name="localidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:Localidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Localidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('localidad'));
    }

    /**
     * Creates a form to delete a Localidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
