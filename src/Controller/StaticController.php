<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package App\Controller
 */
class StaticController extends Controller
{
    /**
     * @Route("", name="home")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function home()
    {
        return $this->json(['version' => 'v1']);
    }
}
