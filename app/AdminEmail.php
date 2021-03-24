<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminEmail extends Model
{
    protected $table = 'admin_emails';
    protected $fillable = ['email'];
}
