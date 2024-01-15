<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialImpact extends Model
{
    protected $table = 'social_impact';
    protected $fillable = ['title', 'publish', 'sortnumber', 'modified_by'];
    protected $primaryKey = 'id';
}
