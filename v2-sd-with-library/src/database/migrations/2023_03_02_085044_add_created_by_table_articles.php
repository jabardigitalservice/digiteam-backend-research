<?php

use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $organizations = Organization::isRoot()->get();

        foreach ($organizations as $organization) {
            $schema = $organization->schema;

            Schema::table($schema . '.articles', function (Blueprint $table) {
                $table->uuid('created_by');
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

            Schema::table($schema . '.articles', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }
    }
};
