<?php

namespace App\Controller;

use App\Client\LinkedIn\Client;
use LinkedIn\AccessToken;
use LinkedIn\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LinkedInController extends AbstractController
{
    /**
     * @Route("/linkedin/oauth/callback", name="linkedin_oauth_callback", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Fetches LinkedIn token"
     * )
     * @SWG\Tag(name="linkedin")
     *
     * @param Request $request
     * @param Client  $client
     *
     * @return Response
     *
     * @throws \LinkedIn\Exception
     */
    public function oauthCallback(Request $request, Client $client)
    {
        if ($request->query->has('code')) {
            $client->getAccessToken($request->query->get('code'));
            $response = new Response('LinkedIn token has been refreshed.');
        } else {
            $response = new RedirectResponse($client->getLoginUrl($client->getScopes()));
        }

        return $response;
    }

    /**
     * @Route("/linkedin/user", name="linkedin_user", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user details"
     * )
     * @SWG\Tag(name="linkedin")
     *
     * @param Client $client
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Client $client)
    {
        try {
            if ($client->getAccessToken() instanceof AccessToken) {
                return $this->json($client->get('people/~:(id,email-address,first-name,last-name)'));
            }
        } catch (Exception $e) {
        }

        return $this->redirectToRoute('linkedin_oauth_callback');
    }
}
