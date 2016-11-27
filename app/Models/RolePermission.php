<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolePermission
 */
class RolePermission extends Model
{
    protected $table = 'role_permissions';

    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    protected $guarded = [];

        
}