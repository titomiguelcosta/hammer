<?php

namespace App\Controller;

use Github\Client;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @SWG\Tag(name="github")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function repos(Client $client)
    {
        return $this->json($client->currentUser()->repositories());
    }
}
