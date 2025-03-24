<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    public function assistances(): HasMany
    {
        //return $this->hasMany(AssistanceTeacher::class)->orderBy('id', 'desc');
        return $this->hasMany(AssistanceTeacher::class);
    }
}
