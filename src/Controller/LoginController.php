<?php

namespace App\Controller;

use App\Entity\User;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\VarDumper\VarDumper;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/connectGoogle", name="connect_google")
     */
    public function connectGoogle()
    {

        return $this->get('knpu.oauth2.client.google')->redirect();
    }


    /**
     * @return GoogleClient
     */
    private function getGoogleClient()
    {
        return $this->get('knpu.oauth2.client.google');
    }


    /**
     * @Route("/connectGoogleCheck", name="connect_google_check")
     */
    public function connectGoogleCheck()
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient $client */
        $client = $this->getGoogleClient();


        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            try {
                VarDumper::dump("IS NOT AUTHENTICATED FULLY");

                $accessToken = $client->getAccessToken();
                VarDumper::dump($accessToken);
                // the exact class depends on which provider you're using
                /** @var \League\OAuth2\Client\Provider\GoogleUser $user */
                $user = $client->fetchUserFromToken($accessToken);
                $this->getUser();

                VarDumper::dump($user);
                $existingUser = $this->getDoctrine()->getManager()->getRepository('App:User')
                    ->findOneBy(['email' => $user->getEmail()]);

                VarDumper::dump($user);
                VarDumper::dump($existingUser);


                if ($existingUser) {
                    return $this->redirectToRoute('index');
                } else {
                    $success = $this->newGoogleUser($user);
                    if ($success)
                        return $this->redirectToRoute('index');
                }

                // do something with all this new power!
                //return new JsonResponse($user->getEmail());
                // ...
            } catch (IdentityProviderException $e) {
                // something went wrong!
                // probably you should return the reason to the user
                var_dump($e->getMessage());
                die;
            }
        }
        else{
            return $this->redirectToRoute('profile');
        }
    }

    /**
     * @Route("/newGoogleUser", name="new_google_user")
     *
     */
    public function newGoogleUser($user)
    {
        $newUser = new User();

        $newUser->setEmail($user->getEmail());
        $newUser->setGoogleId($user->getId());

        //VarDumper::dump($newUser);
        $success = $this->getDoctrine()->getManager()->persist($newUser);

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(array($success, $newUser));
    }
}
