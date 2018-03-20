<?php

namespace App\Controller;

use App\Client\LinkedIn\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package App\Controller
 */
class LinkedInController extends Controller
{
    /**
     * @Route("/linkedin/oauth/callback", name="linkedin_oauth_callback")
     * @param Request $request
     * @param Client $client
     * @return Response
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
     * @Route("/linkedin/user", name="linkedin_user")
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \LinkedIn\Exception
     */
    public function profile(Client $client)
    {
        return $this->json($client->get('people/~:(id,email-address,first-name,last-name)'));
    }
}
