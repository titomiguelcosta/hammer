<?php

namespace App\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;
use OpenApi\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TwitterController extends AbstractController
{
    /**
     * @Route("/twitter/user", name="twitter_user", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user details"
     * )
     * @SWG\Tag(name="twitter")
     */
    public function user(TwitterOAuth $client): JsonResponse
    {
        return $this->json($client->get('users/show', ['user_id' => $_ENV['TWITTER_USER_ID']]));
    }

    /**
     * @Route("/twitter/tweets", name="twitter_tweets", methods="GET")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the user tweets"
     * )
     * @SWG\Tag(name="twitter")
     */
    public function tweets(TwitterOAuth $client): JsonResponse
    {
        return $this->json($client->get('statuses/user_timeline', ['count' => 25, 'exclude_replies' => true]));
    }
}
