<?php

namespace PWD\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use PWD\UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $user=new User();
        $createForm=$this->get('form.factory')->createBuilder(FormType::class,$user);
        $createForm
                ->add('username',null,['translation_domain'=>'FOSUserBundle','label'=>false,'attr'=>['placeholder'=>"Votre nom d'utilisateur..."]])
                ->add('email', EmailType::class,['translation_domain'=>'FOSUserBundle','label'=>false,'attr'=>['placeholder'=>"Votre adresse mail..."]])
                ->add('plainPassword', RepeatedType::class,[
                    'type'=> PasswordType::class,
                    'options'=> ['translation_domain'=>'FOSUserBundle'],
                    'first_options'=> ['label'=>false,'attr'=>['placeholder'=>"Votre mot de passe..."]],
                    'second_options'=> ['label'=>false,'attr'=>['placeholder'=>"Vérifier votre mot de passe..."]],
                    'invalid_message'=> "fos_user.password.mismatch",
                ])
                ->add('submit', SubmitType::class,['attr'=>['class'=>'btn btn-primary slibidur',"value"=>"Valider"]])
                ->add('reset', ResetType::class,['attr'=>['class'=>'btn btn-reset slibidur slibidur-cendre',"value"=>"Effacer"]])
                ->setMethod('POST');
        $create=$createForm->getForm();
        
        if($request->isMethod('POST') && $create->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user->setEnabled(true);
            $em->persist($user);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice','Message bien enregistré.');
            return $this->redirectToRoute('pwd_anime_index');
        }
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('pwd_anime_index');
        }
        $authenticationUtils = $this->get('security.authentication_utils');
        return $this->render('PWDUserBundle:Security:login.html.twig', ['searchForm'=>$searchForm->createView(),'createForm'=>$create->createView(),'error'=>$authenticationUtils->getLastAuthenticationError()]);
    }
}
