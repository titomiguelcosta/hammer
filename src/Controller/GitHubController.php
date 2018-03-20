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
     */
    public function user()
    {
        /** @var Client $client */
        $client = $this->get('Github\Client');

        return $this->json($client->currentUser()->show());
    }

    /**
     * @Route("/github/repos", name="github_repos")
     */
    public function repos()
    {
        /** @var Client $client */
        $client = $this->get('Github\Client');

        return $this->json($client->currentUser()->repositories());
    }
}
