<?php

namespace App\Controller;

use Github\Client;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Swagger\Annotations as SWG;

class GitHubController extends AbstractController
{
    /**
     * @Route("/github/user", name="github_user", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user details"
     * )
     * @SWG\Tag(name="github")
     *
     * @param Client $client
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function user(Client $client)
    {
        return $this->json($client->currentUser()->show());
    }

    /**
     * @Route("/github/repos", name="github_repos", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user repos"
     * )
     *
     * @param Client $client
     * @SWG\Tag(name="github")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function repos(Client $client)
    {
        return $this->json($client->currentUser()->repositories());
    }
}
