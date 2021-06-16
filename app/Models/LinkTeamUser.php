<?php


namespace App\Models;
use \App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class LinkTeamUser extends Model
{
    use UsesUuid;

    protected $table = 'link_team_user';
    protected $fillable = [
        'user', 'team'
    ];

}
