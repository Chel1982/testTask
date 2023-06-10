<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserUrl extends Model
{
    use HasFactory;

    public function urls(): HasMany
    {
        return $this->hasMany(Url::class);
    }
}
