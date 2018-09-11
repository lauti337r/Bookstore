<?php

namespace App\Controller;

//use Security\MyGoogleAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\Cart;

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
            $user = $this->getUser();
            if(!$user->getCart()){
                $newCart = new Cart();
                $newCart->setUser($user);
                $user->setCart($newCart);
                $em->persist($user);
                $em->flush();
            }
            $this->get('session')->set('cart',$user->getCart());

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
