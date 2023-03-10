<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function me();
    public function store($request);
    public function userOrganization($user, $organization_id);
}
