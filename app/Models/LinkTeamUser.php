<?php


namespace App\Models;
use \App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class LinkTeamUser extends Model
{
    use UsesUuid;

    protected $fillable = [
        'user', 'team'
    ];

}
