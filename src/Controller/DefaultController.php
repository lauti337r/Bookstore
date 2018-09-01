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
        //$myGoogleAuth = new MyGoogleAuthenticator();

        if($this->getUser()){
            VarDumper::dump("YOU ARE AUTH");
            VarDumper::dump($this->getUser());
        }else VarDumper::dump("YOU ARE NOT AUTH");

        return $this->render('default/index.html.twig', [
            'user' => $this->getUser()
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
