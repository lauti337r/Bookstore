<?php

namespace App\Controller;

//use Security\MyGoogleAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('session')->set('genres',$em->getRepository('App:Genre')->findAll());
        if($this->getUser()){
            VarDumper::dump("YOU ARE AUTH");
            VarDumper::dump($this->getUser());
        }else VarDumper::dump("YOU ARE NOT AUTH");

        $genres = $em->getRepository('App:Genre')->findAll();
        return $this->render('default/index.html.twig', [
            'user' => $this->getUser(),
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request)
    {
        return $this->render('default/profile.html.twig', [
            'user' => $this->getUser()
        ]);

    }
}
