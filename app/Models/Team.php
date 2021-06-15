<?php


namespace App\Models;
use \App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name', 'team_leader'
    ];
}
