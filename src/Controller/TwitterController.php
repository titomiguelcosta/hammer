<?php

namespace App\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package App\Controller
 */
class TwitterController extends Controller
{
    /**
     * @Route("/twitter/user", name="twitter_user")
     * @param TwitterOAuth $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function user(TwitterOAuth $client)
    {
        return $this->json($client->get("users/show", ["user_id" => getenv('TWITTER_USER_ID')]));
    }

    /**
     * @Route("/twitter/tweets", name="twitter_tweets")
     * @param TwitterOAuth $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tweets(TwitterOAuth $client)
    {
        return $this->json($client->get("statuses/user_timeline", ["count" => 25, "exclude_replies" => true]));
    }
}
