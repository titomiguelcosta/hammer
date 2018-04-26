<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swagger\Annotations as SWG;

/**
 * @package App\Controller
 */
class StaticController extends Controller
{
    /**
     * @Route("/healthcheck", name="home", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Health check endpoint"
     * )
     * @SWG\Tag(name="hammer")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function home()
    {
        return $this->json(['version' => 'v1']);
    }
}
