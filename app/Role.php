<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['role_name'];

    public $primaryKey = 'role_id';

    public static function rules($roleId = null)
    {
        $uniqueRule = Rule::unique('roles', 'role_name')->ignore($roleId, 'role_id');

        return [
            'role_name' => ['required', $uniqueRule],
        ];
    }

    // Method to validate the role data
    public static function validateRole($data, $roleId = null)
    {
        return validator($data, self::rules($roleId));
    }
    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }


}
