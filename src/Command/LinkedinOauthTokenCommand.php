<?php

namespace App\Command;

use App\Client\LinkedIn\Client;
use LinkedIn\AccessToken;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LinkedinOauthTokenCommand extends Command
{
    protected static $defaultName = 'linkedin:oauth-token';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $linkedInClient
     */
    public function __construct(Client $linkedInClient)
    {
        parent::__construct();
        $this->client = $linkedInClient;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate or refresh the LinkedIn access token')
            ->addOption('code', null, InputOption::VALUE_REQUIRED, 'Code in the callback url', '');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \LinkedIn\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $accessToken = $this->client->getAccessToken($input->getOption('code'));

        if ($accessToken instanceof AccessToken) {
            $io->success('Your access token: '.$accessToken->getToken());
            $this->client->setAccessToken($accessToken);

            // test calling endpoint
            $profile = $this->client->get('people/~:(id,email-address,first-name,last-name)');
            $io->block(print_r($profile, true));
        } else {
            $io->warning(sprintf('You need to login on: %s', urldecode($this->client->getLoginUrl($this->client->getScopes()))));
        }
    }
}
