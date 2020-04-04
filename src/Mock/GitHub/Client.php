<?php

namespace App\Mock\GitHub;

use App\Mock\GitHub\Api\CurrentUser;
use Github\Client as BaseClient;

class Client extends BaseClient
{
    public function currentUser()
    {
        return new CurrentUser($this);
    }
}
