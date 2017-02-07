<?php

namespace PWD\AnimeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
class AnimeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',  TextType::class,['attr'=>['class'=>'','placeholder'=>'Titre'],'label'=>false])
            ->add('genre', ChoiceType::class,['choices'=>['Action'=>'action','Aventure'=>'aventure','Sci-fi'=>'sci-fi','Ecchi'=>'ecchi','Magical girl'=>'magical'],'attr'=>['class'=>'','placeholder'=>'Statut'],'label'=>false])
            ->add('year',   IntegerType::class,['attr'=>['class'=>'','placeholder'=>'Année de parution'],'label'=>false])
            ->add('statut', ChoiceType::class,['choices'=>['En cours'=>0,'Terminé'=>1],'attr'=>['class'=>'','placeholder'=>'Statut'],'label'=>false])
            ->add('episode',IntegerType::class,['attr'=>['class'=>'','placeholder'=>"Nombre d'épisode"],'label'=>false])
            ->add('trailer',TextType::class,['attr'=>['class'=>'','placeholder'=>'Lien bande annonce'],'label'=>false])
            ->add('resume', TextareaType::class,['attr'=>['class'=>'','placeholder'=>'Résumé'],'label'=>false])
            ->add('image',  ImageType::class,['attr'=>['class'=>'','placeholder'=>'Image'],'label'=>false])
            ->add('imgMin', ImgMinType::class,['attr'=>['class'=>'','placeholder'=>'Miniature'],'label'=>false])
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
            'data_class' => 'PWD\AnimeBundle\Entity\Anime'
        ));
    }
}
