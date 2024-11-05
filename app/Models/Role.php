<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($role) {
            DB::table('role_permission')->where('role_id', $role->id)->delete();
        });
    }

}
