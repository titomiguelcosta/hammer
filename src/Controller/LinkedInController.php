<?php

namespace App\Controller;

use App\Client\LinkedIn\Client;
use LinkedIn\AccessToken;
use LinkedIn\Exception;
use OpenApi\Annotations as SWG;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session;

class LinkedInController extends AbstractController
{
    public function __construct(private RequestStack $requestStack, private LoggerInterface $logger)
    {
    }

    /**
     * @Route("/linkedin/oauth/callback", name="linkedin_oauth_callback", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Fetches LinkedIn token"
     * )
     * @SWG\Tag(name="linkedin")
     *
     * @return Response
     *
     * @throws \LinkedIn\Exception
     */
    public function oauthCallback(Request $request, Client $client)
    {
        if ($request->query->has('code')) {
            $client->getAccessToken($request->query->get('code'));
            /** @var Session $session  */
            $session = $this->requestStack->getSession();

            if ($referrer = $session->getFlashBag()->get('linkedin.referrer')) {
                $response = new RedirectResponse(array_pop($referrer));
            } else {
                $response = new Response('LinkedIn token has been refreshed.');
            }
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Client $client)
    {
        try {
            if ($client->getAccessToken() instanceof AccessToken) {
                return $this->json($client->get('me'));
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        // before redirect, store url
        $this->addFlash('linkedin.referrer', $this->generateUrl('linkedin_user', [], UrlGeneratorInterface::ABSOLUTE_URL));

        return $this->redirectToRoute('linkedin_oauth_callback');
    }
}
