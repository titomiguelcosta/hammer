<?php

namespace App\Controller;

use OpenApi\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    /**
     * @Route("/healthcheck", name="healthcheck", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Health check endpoint"
     * )
     * @SWG\Tag(name="hammer")
     */
    public function healthcheck(): JsonResponse
    {
        return $this->json(['version' => 'v1', 'branch' => $_ENV['BRANCH_NAME']]);
    }
}
