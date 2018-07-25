<?php

namespace App\Mock\GitHub;

use Github\Client as BaseClient;
use App\Mock\GitHub\Api\CurrentUser;

class Client extends BaseClient
{
    public function currentUser()
    {
        return new CurrentUser($this);
    }
}
