<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 30/08/18
 * Time: 13:59
 */

namespace App\Security;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class GoogleAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $em;
    private $router;

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function __construct(ClientRegistry $clientRegistry, ObjectManager $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true

        // For Symfony lower than 3.4 the supports method need to be called manually here:
        // if (!$this->supports($request)) {
        //     return null;
        // }

        return $this->fetchAccessToken($this->getGoogleClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $GoogleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        // 1) have they logged in with Facebook before? Easy!
        $existingUser = $this->em->getRepository('App:User')
            ->findOneBy(['googleId' => $googleUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

        // 2) do we have a matching user by email?
        $user = $this->em->getRepository('App:User')
            ->findOneBy(['email' => $email]);
        if(!$user)
            $user = new User();
        // 3) Maybe you just want to "register" them by creating
        // a User object
        //VarDumper::dump($googleUser->toArray()['image']['url']);
        $user->setFirstName($googleUser->getFirstName());
        $user->setLastName($googleUser->getLastName());
        $user->setProfilePic(substr($googleUser->getAvatar(),0,strlen($googleUser->getAvatar())-5));
        $user->setGoogleId($googleUser->getId());
        $user->setEmail($googleUser->getEmail());
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @return GoogleClient
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry
            // "google" is the key used in config.yml
            ->getClient('google');
    }
}