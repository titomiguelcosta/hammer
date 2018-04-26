<?php

namespace App\Controller;

use Github\Client;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package App\Controller
 */
class GitHubController extends Controller
{
    /**
     * @Route("/github/user", name="github_user")
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function user(Client $client)
    {
        return $this->json($client->currentUser()->show());
    }

    /**
     * @Route("/github/repos", name="github_repos")
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function repos(Client $client)
    {
        return $this->json($client->currentUser()->repositories());
    }
}
