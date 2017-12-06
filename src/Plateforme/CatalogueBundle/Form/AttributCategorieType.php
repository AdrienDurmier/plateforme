<?php

namespace Plateforme\CatalogueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AttributCategorieType extends AbstractType {

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('nom')
        ->add('type')
        ->add('type', ChoiceType::class, array(
          'choices' => array(
            "Liste déroulante" => 'liste',
            "Boutons radio" => 'radio',
            "Couleur" => 'couleur',
          )
        ))
    ;
  }

  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Plateforme\CatalogueBundle\Entity\AttributCategorie'
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix() {
    return 'plateforme_cataloguebundle_attributcategorie';
  }

}
