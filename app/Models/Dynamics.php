<?php


namespace App\Models;
use \App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Dynamics extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name', 'description'
    ];
}


