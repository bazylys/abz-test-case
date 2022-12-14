<?php

namespace App\Models;

use App\Models\Traits\StaticHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;
    use StaticHelpers;

    protected $guarded = [];

    protected $primaryKey = 'token';

    public $incrementing = false;

    protected $keyType = 'string';
}
