<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    protected $table = 'subuser';
	protected $primary = 'id';

    protected $fillable = [
        'username', 'password', 'token', 'cid', 'role', 'status'
    ];
    
    public $timestamps = false;
}
