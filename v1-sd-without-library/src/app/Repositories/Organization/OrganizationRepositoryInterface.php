<?php

namespace App\Repositories\Organization;

interface OrganizationRepositoryInterface
{
    public function store($request);
    public function schema($organization_schema);
}
