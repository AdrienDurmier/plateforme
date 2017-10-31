<?php

namespace Plateforme\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdresseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse')
            ->add('complement')
            ->add('code_postal')
            ->add('commune')
            ->add('pays')
            ->add('pays', CountryType::class,
                array(
                  'data' => 'FR'
                ))
            ->add('livraison', CheckboxType::class, 
                array(
                  'required' => false,
                  'label' => 'Adresse de livraison'
                ))
            ->add('facturation', CheckboxType::class, 
                array(
                  'required' => false,
                  'label' => 'Adresse de facturation'
                ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plateforme\CoreBundle\Entity\Adresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'plateforme_corebundle_adresse';
    }


}
