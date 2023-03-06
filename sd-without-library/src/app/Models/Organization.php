<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;
    use Uuid;
    use HasRecursiveRelationships;
    use Hashid;

    public $guarded = [];

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function getLocalKeyName()
    {
        return 'id';
    }

    public function getCustomPaths()
    {
        return [
            [
                'name' => 'slug_path',
                'column' => 'slug',
                'separator' => '/',
            ],
        ];
    }

    public function getDepthName()
    {
        return 'depth';
    }

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Organization $organization) {
            $organization->id = Str::uuid();
            $organization->slug = Str::slug($organization->name);
            $organization->schema = Str::slug($organization->name, '_') . '_' . str_replace('-', '', Str::uuid());
        });
    }
}
