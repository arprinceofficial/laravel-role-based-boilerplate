<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    protected $fillable = ['name'];

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($permission) {
            DB::table('role_permission')->where('permission_id', $permission->id)->delete();
        });
    }

}
