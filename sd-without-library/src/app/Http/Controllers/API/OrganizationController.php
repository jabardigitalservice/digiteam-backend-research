<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OrganizationRequest;
use App\Repositories\Organization\OrganizationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class OrganizationController extends Controller
{
    private $organizationRepository;
    private $userRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository, UserRepositoryInterface $userRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository = $userRepository;
    }

    public function store(OrganizationRequest $request)
    {
        DB::beginTransaction();
        try {
            $organization = $this->organizationRepository->store($request->only('name', 'description')); //create organization
            $user = $this->userRepository->store($request->except('name', 'description')); // create user
            $this->userRepository->userOrganization($user, $organization->id); // attach pivot user organization
            $this->organizationRepository->schema($organization->schema); // create schema
            DB::commit();
            return response()->format(Response::HTTP_OK, 'organization created successfully', $organization);
        } catch (Exception $e) {
            DB::rollback();
            return response()->format(Response::HTTP_INTERNAL_SERVER_ERROR, 'organization created unsuccessfully', $e->getMessage());
        }
    }
}
