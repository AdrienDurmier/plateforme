<?php

namespace Plateforme\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class FAQQuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('reponse',  CKEditorType::class, array('config_name' => 'full_config',))
            ->add('weight')
            ->add('page_faq')
            ->add('faq_categorie')
            ->add('published');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plateforme\CoreBundle\Entity\FAQQuestion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'plateforme_corebundle_faqquestion';
    }


}
