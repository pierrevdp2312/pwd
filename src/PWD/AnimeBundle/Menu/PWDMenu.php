<?php
namespace PWD\AnimeBundle\Menu;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PWDMenu{
    
    private $formFactory;
    private $router;
    
    public function __construct($formFactory,$router) {
        $this->formFactory = $formFactory;
        $this->router = $router->generate('pwd_anime_search');
    }
    public function displayForm(){
        $searchForm = $this->formFactory
                ->createNamedBuilder(null,FormType::class,null,["attr"=>["class"=>"search"]])
                ->add('keywords',TextType::class,["label"=>false,"attr"=>["class"=>"search-bar","placeholder"=>"Rechercher"],'required'=>false])
                ->add('genre', ChoiceType::class,['choices'=>['Tous les animes'=>'','Action'=>'action','Aventure'=>'aventure','Sci-fi'=>'sci-fi','Ecchi'=>'ecchi','Magical girl'=>'magical'],'attr'=>['class'=>'','placeholder'=>'Statut'],'label'=>false,'required'=>false])
                /*->add('submit',SubmitType::class,["label"=>false,"attr"=>["class"=>"search-button"]])*/ 
                ->setAction($this->router)
                ->setMethod('GET')
                ->getForm();
        return $searchForm;
    }
}