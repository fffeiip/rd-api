<?php


namespace App\Models;

use \App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;


class LinkDynamicsUser extends Model
{
    use UsesUuid;
    protected $fillable = [
        'participant', 'dynamics', 'created_by'
    ];
}
