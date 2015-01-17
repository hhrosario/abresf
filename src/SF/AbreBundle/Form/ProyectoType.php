<?php

namespace SF\AbreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProyectoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('orden')
            ->add('observacion')
            ->add('fecha','date',array(
                'widget' => 'single_text'
            ))
            ->add('eje_trabajo')
            ->add('intervencion')
            ->add('linea_accion')
            ->add('dato_geografico')
            ->add('localidad')
            ->add('cuerpo_publico')
            ->add('bajada_publica')
            ->add('monto_publico')
            ->add('titulo_publico')
            ->add('enlace')
            ->add('publicar')
            ->add('mostrar_monto')
            ->add('leido')
            ->add('imagen', new ImagenType(), array(
               'error_bubbling' => true
            ))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SF\AbreBundle\Entity\Proyecto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sf_abrebundle_proyecto';
    }
}
