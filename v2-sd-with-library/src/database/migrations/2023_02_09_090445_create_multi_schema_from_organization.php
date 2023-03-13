<?php

use App\Models\Organization;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $organizations = ['Jabar Digital Service', 'Diskominfo Jabar', 'Disdik Jabar', 'Dishub Jabar'];
        foreach ($organizations as $organization) {

            $tenant = Tenant::create(['name' => $organization, 'domain' => Str::slug(
                $organization
            )]);

            $parent = Organization::create([
                'tenant_id' => $tenant->id,
                'name' => $organization,
                'slug' => Str::slug($organization),
                'schema' => Str::slug($organization, '_') . '_' . str_replace('-', '', Str::uuid()),
            ]);

            for ($i = 1; $i < 6; $i++) {
                $childName = 'Divisi ' . $i . ' ' . $organization;
                Organization::create([
                    'tenant_id' => $tenant->id,
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'schema' => Str::slug($childName, '_'),
                    'parent_id' => $parent->id,
                ]);
            }
        }

        $organizations = Organization::isRoot()->get();

        foreach ($organizations as $organization) {
            $schema = $organization->schema;
            \DB::statement("DROP SCHEMA IF EXISTS $schema CASCADE");
            $this->createSchema($schema);

            Schema::create($schema . '.articles', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->text('description');
                $table->string('image');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $organizations = Organization::isRoot()->get();
        foreach ($organizations as $organization) {
            $schema = $organization->schema;
            $this->dropSchema($schema);
        }
    }

    /**
     * Create a new schema.
     *
     * @param string $schema
     * @return void
     */
    private function createSchema(string $schema)
    {
        \DB::statement("CREATE SCHEMA IF NOT EXISTS $schema");
    }

    /**
     * Drop an existing schema.
     *
     * @param string $schema
     * @return void
     */
    private function dropSchema(string $schema)
    {
        \DB::statement("DROP SCHEMA IF EXISTS $schema CASCADE");
    }
};
