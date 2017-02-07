<?php

namespace PWD\AnimeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CommentaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class,['attr'=>['class'=>'','placeholder'=>'Commentaire'],'label'=>false])
            ->add('submit', SubmitType::class,['attr'=>['class'=>'btn btn-primary slibidur','value'=>'Envoyer'],'label'=>false])
            ->add('reset', ResetType::class,['attr'=>['class'=>'btn btn-reset slibidur slibidur-cendre',"value"=>"Effacer"]])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PWD\AnimeBundle\Entity\Commentaire'
        ));
    }
}
