<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function me()
    {
        $organizations = collect(auth()->user()->organization)->map(function ($organization) {
            return $organization->rootAncestor ?: $organization->makeHidden('pivot');
        });

        $data['user'] = auth()->user()->makeHidden('organization');
        $data['user']['organizations'] =  $organizations->unique();

        return $data;
    }

    public function store($request)
    {
        try {
            $data = User::create($request);
            return $data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function userOrganization($user, $organization_id)
    {
        try {
            return $user->organization()->attach(['organization_id' => $organization_id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
