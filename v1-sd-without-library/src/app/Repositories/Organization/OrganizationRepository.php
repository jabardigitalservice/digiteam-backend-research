<?php

namespace App\Repositories\Organization;

use App\Models\Organization;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function store($request)
    {
        try {
            $data = Organization::create($request);
            return $data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function schema($organization_schema)
    {
        DB::statement("CREATE SCHEMA IF NOT EXISTS $organization_schema");
        // Check if the table exists, and create it if it does not exist
        Schema::create($organization_schema . '.articles', function (Blueprint $table) {
            // Define the columns using the dynamically generated column names
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->uuid('created_by');
            $table->timestamps();
        });
        // DB::statement("CREATE TABLE $organization_schema.'.articles' (
        //     id UUID PRIMARY KEY,
        //     title VARCHAR,
        //     description TEXT NULL,
        //     image VARCHAR,
        //     created_at TIMESTAMP DEFAULT NOW(),
        //     updated_at TIMESTAMP DEFAULT NOW(),
        //     created_by UUID NULL
        //   )");
    }
}
