<?php

namespace App\Mock\GitHub\Api;

use Github\Api\CurrentUser as BaseCurrentUser;

class CurrentUser extends BaseCurrentUser
{
    public function show()
    {
        return ['username' => 'tito'];
    }
}
