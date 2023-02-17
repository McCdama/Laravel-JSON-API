<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * @return HasMany
     */
    public function jobLocations(): HasMany
    {
        return $this->hasMany(JobLocation::class);
    }


}
