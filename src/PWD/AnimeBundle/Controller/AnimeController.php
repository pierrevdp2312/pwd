<?php

/* Datatable recherche filtré recupération de mot de passe */

namespace PWD\AnimeBundle\Controller;

use PWD\AnimeBundle\Entity\Anime;
use PWD\AnimeBundle\Entity\Commentaire;
use PWD\AnimeBundle\Entity\Wishlist;
use PWD\AnimeBundle\Entity\View;
use PWD\AnimeBundle\Form\AnimeType;
use PWD\AnimeBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;

class AnimeController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $lastAnimes = $em->getRepository('PWDAnimeBundle:Anime')->findBy(
                array(), array('id' => 'desc'), 8/* contrainte(where),Tri des element (order by,etc),limite (nbr resultat),offset(id de départ) */
        );
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        return $this->render('PWDAnimeBundle:Anime:index.html.twig', array('animes' => $lastAnimes, 'searchForm' => $searchForm->createView()));
    }

    public function adminUserAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PWDUserBundle:User')->findBy(
                array(), array('id' => 'asc')
        );
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        return $this->render('PWDAnimeBundle:Anime:adminUser.html.twig', array('searchForm' => $searchForm->createView(),'users'=>$user));
    }

    public function adminAnimeAction() {
        $em = $this->getDoctrine()->getManager();
        $lastAnimes = $em->getRepository('PWDAnimeBundle:Anime')->findBy(
                array(), array('id' => 'asc')
        );
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        return $this->render('PWDAnimeBundle:Anime:adminAnime.html.twig', array('animes' => $lastAnimes, 'searchForm' => $searchForm->createView()));
    }

    public function contactAction() {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        return $this->render('PWDAnimeBundle:Anime:contact.html.twig', array('searchForm' => $searchForm->createView()));
    }

    public function ficheAction(Request $request, $id) {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $em = $this->getDoctrine()->getManager();
        $ficheAnime = $em->getRepository('PWDAnimeBundle:Anime')->find($id);
        
        $commentaire = new Commentaire;
        $form = $this->get('form.factory')->create(CommentaireType::class, $commentaire);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $commentaire->setAnime($ficheAnime);
            $commentaire->setUser($this->getUser());
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('pwd_anime_fiche',['id'=>$id]);
        }
        
        $commentaires = $em->getRepository('PWDAnimeBundle:Commentaire')->findBy(
            array("anime"=>$id), array('id' => 'desc')
        );
        return $this->render('PWDAnimeBundle:Anime:fiche.html.twig', array('anime' => $ficheAnime, 'searchForm' => $searchForm->createView(),'form'=>$form->createView(),'coms'=>$commentaires));
    }

    public function searchAction(Request $request,$page) {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $em = $this->getDoctrine()->getManager();
        $nbPerPage = 3;
        $paramRoute = array('genre' => $request->query->get('genre'), 'keywords' => $request->query->get('keywords'));
        $ficheAnime = $em->getRepository('PWDAnimeBundle:Anime')->getAnimeSearch($request->query->get('keywords'),$request->query->get('genre'),$nbPerPage,$page);
        $nbPages = ceil(count($ficheAnime) / $nbPerPage);
        if(count($ficheAnime)!=0){
            if ($page > $nbPages || $page < 1) {
                throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
            }
        }

        return $this->render('PWDAnimeBundle:Anime:search.html.twig', array('animes' => $ficheAnime, 'searchForm' => $searchForm->createView(),'nbPages' => $nbPages,'page'=>$page,'paramRoute'=>$paramRoute));
    }

    public function modifAction(Request $request, $id) {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $em = $this->getDoctrine()->getManager();
        $anime = $em->getRepository("PWDAnimeBundle:Anime")->find($id);
        $form = $this->get('form.factory')->create(AnimeType::class, $anime);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //$anime->getImage()->upload();
            $em->persist($anime);
            $em->flush();
            return $this->redirectToRoute('pwd_anime_adminAnime');
        }
        return $this->render('PWDAnimeBundle:Anime:form.html.twig', array('searchForm' => $searchForm->createView(), 'form' => $form->createView()));
    }

    public function addAction(Request $request) {
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $anime = new Anime;
        $form = $this->get('form.factory')->create(AnimeType::class, $anime);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //$anime->getImage()->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($anime);
            $em->flush();
            return $this->redirectToRoute('pwd_anime_adminAnime');
        }
        return $this->render('PWDAnimeBundle:Anime:form.html.twig', array('searchForm' => $searchForm->createView(), 'form' => $form->createView()));
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $anime = $em->getRepository("PWDAnimeBundle:Anime")->find($id);
        $em->remove($anime);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_adminAnime');
    }
    public function deleteComAction($id){
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("PWDAnimeBundle:Commentaire")->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_fiche',['id'=>$id]);
    }
    public function deleteUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("PWDUserBundle:User")->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_adminUser');
    }
    public function userAction() {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $menu = $this->get('pwd_anime.menu');
        $searchForm = $menu->displayForm();
        $em = $this->getDoctrine()->getManager();
        $wish= $em->getRepository('PWDAnimeBundle:Wishlist')->findBy(
                array("user"=>$this->getUser()), array('id' => 'asc')
        );
        $view= $em->getRepository('PWDAnimeBundle:View')->findBy(
                array("user"=>$this->getUser()), array('id' => 'asc')
        );
        $form = $this->get('form.factory')->create(ChangePasswordFormType::class);
        return $this->render('PWDAnimeBundle:Anime:user.html.twig', array('searchForm' => $searchForm->createView(),'views'=>$view,'wishlist'=>$wish,'form'=>$form->createView()));
    }
    public function addViewAction($id){
        $vue=new View;
        $em = $this->getDoctrine()->getManager();
        $anime = $em->getRepository("PWDAnimeBundle:Anime")->find($id);
        $user=$this->getUser();
        $vue->setAnime($anime);
        $vue->setUser($user);
        $em->persist($vue);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_user');
    }
    public function addWishAction($id){
        $wish=new Wishlist;
        $em = $this->getDoctrine()->getManager();
        $anime = $em->getRepository("PWDAnimeBundle:Anime")->find($id);
        $user=$this->getUser();
        $wish->setAnime($anime);
        $wish->setUser($user);
        $em->persist($wish);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_user');
    }
    public function deleteWishAction($id){
        $em = $this->getDoctrine()->getManager();
        $wish = $em->getRepository("PWDAnimeBundle:Wishlist")->find($id);
        $em->remove($wish);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_user');
    }
    public function deleteViewAction($id){
        $em = $this->getDoctrine()->getManager();
        $view = $em->getRepository("PWDAnimeBundle:View")->find($id);
        $em->remove($view);
        $em->flush();
        return $this->redirectToRoute('pwd_anime_user');
    }
}
