<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 */
class Permission extends Model
{
    protected $table = 'permissions';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at', 'pivot', 'id'
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}