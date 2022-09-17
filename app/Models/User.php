<?php

namespace App\Models;

use App\Models\Traits\StaticHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use StaticHelpers;

    protected $guarded = [];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
