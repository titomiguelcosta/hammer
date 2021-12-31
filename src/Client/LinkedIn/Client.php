<?php

namespace App\Client\LinkedIn;

use App\Entity\OAuth;
use App\Repository\OAuthRepository;
use LinkedIn\AccessToken;
use LinkedIn\Client as LinkedInClient;
use LinkedIn\Exception as LinkedInException;

class Client extends LinkedInClient
{
    protected $OAuthRepository;

    public function __construct(OAuthRepository $OAuthRepository, string $clientId = '', string $clientSecret = '')
    {
        parent::__construct($clientId, $clientSecret);
        $this->setApiRoot('https://api.linkedin.com/v2/');
        $this->setApiHeaders([
            'Content-Type' => 'application/json',
            'x-li-format' => 'json',
            'X-Restli-Protocol-Version' => '2.0.0',
        ]);
        $this->OAuthRepository = $OAuthRepository;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \LinkedIn\Exception
     */
    public function handleAccessToken(): void
    {
        $oauthToken = $this->OAuthRepository->getLinkedInToken();
        if ($oauthToken instanceof OAuth) {
            if (!$oauthToken->hasExpired()) {
                $this->setAccessToken(
                    new AccessToken($oauthToken->getAccessToken(), $oauthToken->getExpiresAt()->getTimestamp())
                );
            } else {
                new LinkedInException('LinkedIn Token has expired.');
            }
        }
    }

    /**
     * @param AccessToken|string $accessToken
     *
     * @return AccessToken|LinkedInClient|string
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \LinkedIn\Exception
     */
    public function setAccessToken($accessToken)
    {
        $accessToken = parent::setAccessToken($accessToken);

        $this->OAuthRepository->setLinkedInToken($this->getAccessToken());

        return $accessToken;
    }

    public function getScopes(): array
    {
        return explode(',', $_ENV['LINKEDIN_APP_SCOPE']);
    }
}
