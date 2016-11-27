<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 */
class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}