<?php

namespace SF\AbreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SF\AbreBundle\Entity\Distrito;
use SF\AbreBundle\Form\DistritoType;

/**
 * Distrito controller.
 *
 * @Route("/distrito")
 */
class DistritoController extends Controller
{

    /**
     * Lists all Distrito entities.
     *
     * @Route("/", name="distrito")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SFAbreBundle:Distrito')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Importar intervenciones desde el webservice
     *
     * @Route("/importar", name="distrito_importar")
     * @Method("GET")
     * @Template()
     */
    public function importarAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Vacía la tabla de Intervenciones
        $cmd = $em->getClassMetadata("SFAbreBundle:Distrito");
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        // Bucle por las lineas de acción del WebService
        $localidades = $em->getRepository('SFAbreBundle:Localidad')->findAll();

        foreach($localidades as $localidad) {

            $distritos = $this->container->get("sfabre.wsgs")->getDistritos($localidad->getId());

            if(!empty($distritos)) {

                if (isset($distritos->item)) {

                    foreach($distritos->item as $distrito) {
                        $distritoModelo = new Distrito();
                        $distritoModelo->setId($distrito->dis_id);
                        $distritoModelo->setNombre($distrito->dis_nombre);
                        $distritoModelo->setNumero($distrito->dis_nro);

                        $distritoModelo->setLocalidad($localidad);
                        $em->persist($distritoModelo);
                    }

                }

            }

        }

        $em->flush();
        
        return $this->redirect($this->generateUrl('distrito'));

    }


    /**
     * Creates a new Distrito entity.
     *
     * @Route("/", name="distrito_create")
     * @Method("POST")
     * @Template("SFAbreBundle:Distrito:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Distrito();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('distrito_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Distrito entity.
     *
     * @param Distrito $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Distrito $entity)
    {
        $form = $this->createForm(new DistritoType(), $entity, array(
            'action' => $this->generateUrl('distrito_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Distrito entity.
     *
     * @Route("/new", name="distrito_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Distrito();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Distrito entity.
     *
     * @Route("/{id}", name="distrito_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Distrito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distrito entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Distrito entity.
     *
     * @Route("/{id}/edit", name="distrito_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Distrito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distrito entity.');
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
    * Creates a form to edit a Distrito entity.
    *
    * @param Distrito $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Distrito $entity)
    {
        $form = $this->createForm(new DistritoType(), $entity, array(
            'action' => $this->generateUrl('distrito_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Distrito entity.
     *
     * @Route("/{id}", name="distrito_update")
     * @Method("PUT")
     * @Template("SFAbreBundle:Distrito:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SFAbreBundle:Distrito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distrito entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('distrito_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Distrito entity.
     *
     * @Route("/{id}", name="distrito_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SFAbreBundle:Distrito')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Distrito entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('distrito'));
    }

    /**
     * Creates a form to delete a Distrito entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('distrito_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
