<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\Barrio;
use SF\AbreBundle\Form\BarrioType;

/**
 * Barrio controller.
 *
 * @Route("/admin/barrio")
 */
class BarrioController extends Controller
{

    /**
     * Lists all Barrio entities.
     *
     * @Route("/", name="barrio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:Barrio')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar intervenciones desde el webservice
     *
     * @Route("/importar", name="barrio_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Vacía la tabla de Intervenciones
        $cmd = $em->getClassMetadata("SFAbreBundle:Barrio");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        // Bucle por las lineas de acción del WebService
        $localidades = $em->getRepository('SFAbreBundle:Localidad')->findAll();

        foreach($localidades as $localidad) {

            $barrios = $this->container->get("sfabre.wsgs")->getBarrios($localidad->getId());

            if(!empty($barrios)) {

                foreach($barrios->item as $barrio) {
                    $barrioModelo = new Barrio();
                    $barrioModelo->setId($barrio->bar_id);
                    $barrioModelo->setNombre($barrio->bar_nombre);
                    $barrioModelo->setNumero($barrio->bar_nro);

                    $barrioModelo->setLocalidad($localidad);
                    $em->persist($barrioModelo);
                }

            }

        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('barrio'));

    }

    /**
     * Creates a new Barrio entity.
     *
     * @Route("/", name="barrio_create")
     * @Method("POST")
     * @Template("SFAbreBundle:Barrio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Barrio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('barrio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Barrio entity.
     *
     * @param Barrio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Barrio $entity)
    {
        $form = $this->createForm(new BarrioType(), $entity, array(
            'action' => $this->generateUrl('barrio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Barrio entity.
     *
     * @Route("/new", name="barrio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Barrio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Barrio entity.
     *
     * @Route("/{id}", name="barrio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Barrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barrio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Barrio entity.
     *
     * @Route("/{id}/edit", name="barrio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Barrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barrio entity.');
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
    * Creates a form to edit a Barrio entity.
    *
    * @param Barrio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Barrio $entity)
    {
        $form = $this->createForm(new BarrioType(), $entity, array(
            'action' => $this->generateUrl('barrio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Barrio entity.
     *
     * @Route("/{id}", name="barrio_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:Barrio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Barrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barrio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('barrio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Barrio entity.
     *
     * @Route("/{id}", name="barrio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:Barrio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Barrio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('barrio'));
    }

    /**
     * Creates a form to delete a Barrio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barrio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
