<?php

namespace App\Controller;

use Facebook\Facebook;
use OpenApi\Annotations as SWG;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FacebookController extends AbstractController
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @var Session
     */
    private $session;

    public function __construct(private RequestStack $requestStack, private LoggerInterface $logger)
    {
        $this->session = $requestStack->getSession();
        $this->session->start();
        
        $this->facebook = new Facebook(['persistent_data_handler' => 'session']);
    }

    /**
     * @Route("/facebook/oauth/callback", name="facebook_oauth_callback", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Fetches Facebook token"
     * )
     * @SWG\Tag(name="facebook")
     */
    public function oauthCallback(Request $request): RedirectResponse
    {
        if ($request->query->has('code') && $request->query->has('state')) {
            $accessToken = $this->facebook->getRedirectLoginHelper()->getAccessToken();
            $this->addFlash('facebook.access_token', $accessToken->getValue());

            if ($referrer = $this->session->getFlashBag()->get('facebook.referrer')) {
                $response = new RedirectResponse(array_pop($referrer));
            } else {
                $response = new RedirectResponse($this->generateUrl('facebook_user', [], UrlGeneratorInterface::ABSOLUTE_URL));
            }
        } else {
            $loginUrl = $this->facebook->getRedirectLoginHelper()->getLoginUrl(
                $this->generateUrl('facebook_oauth_callback', [], UrlGeneratorInterface::ABSOLUTE_URL),
                ['email', 'public_profile']
            );

            $response = new RedirectResponse($loginUrl);
        }

        return $response;
    }

    /**
     * @Route("/facebook/user", name="facebook_user", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user details"
     * )
     * @SWG\Tag(name="facebook")
     */
    public function profile(): Response
    {
        try {
            $accessToken = $this->session->getFlashBag()->get('facebook.access_token');

            if (!$accessToken) {
                return $this->redirectToRoute('facebook_oauth_callback');
            }
            $response = $this->facebook->get('/me', array_pop($accessToken));
            $me = $response->getGraphUser();

            return new JsonResponse($me->asArray());
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // before redirect, store url
        $this->addFlash('facebook.referrer', $this->generateUrl('facebook_user', [], UrlGeneratorInterface::ABSOLUTE_URL));

        return $this->redirectToRoute('facebook_oauth_callback');
    }
}
