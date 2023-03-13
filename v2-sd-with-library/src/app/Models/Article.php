<?php

namespace App\Models;

use App\Traits\SwitchSchema;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Article extends Model
{
    use HasFactory;
    use Uuid;
    use SwitchSchema;

    public $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
