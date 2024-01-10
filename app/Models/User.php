<?php

namespace App\Models;

use App\Traits\EncryptionTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, EncryptionTrait;

    protected $table = 'users';

    protected $guard_name = 'admin';

    protected $fillable = [
        'username', 'name', 'email', 'password', 'status',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /////////////////
    function getIdHashAttribute()
    {
        return $this->encrypt($this->id);
    }
    /////////////////////////////////////////////////////////
    public function getHumansDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
    /////////////////
    function addUser($username, $name, $email, $password, $status)
    {
        $this->username = $username;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;

        $this->save();
        return $this;
    }
    ////////////////////
    function updateUser($obj, $username, $name, $email, $status)
    {
        $obj->username = $username;
        $obj->name = $name;
        $obj->email = $email;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    ///////////////////////////////////////////
    function updateProfile($obj, $name, $email)
    {
        $obj->name = $name;
        $obj->email = $email;

        $obj->save();
        return $obj;
    }
    ///////////////////////////////////////
    function updatePassword($id, $password)
    {
        return $this
            ->where('id', '=', $id)
            ->update([
                'password' => $password
            ]);
    }
    ////////////////////////////////
    function deleteUser($obj)
    {
        return $obj->delete();
    }
    /////////////////////
    function getUser($id)
    {
        return $this->find($id);
    }
    //////////////////////////
    function getAllCountUsers()
    {
        return $this->count('id');
    }
    //////////////////////////
    function getUsersPaginated($skip = 0, $take = 5, $username = null, $name = null, $email = null)
    {
        $query = $this;
        if (!is_null($username))
        {
            $query = $query->where('username', 'LIKE', '%' . $username . '%');
        }
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if (!is_null($email))
        {
            $query = $query->where('email', 'LIKE', '%' . $email . '%');
        }
        return $query->skip($skip)->take($take);
    }
    ///////////////////////////////////////////////////////////
    function countUsersPaginated($username = null, $name = null, $email = null)
    {
        $query = $this;
        if (!is_null($username))
        {
            $query = $query->where('username', 'LIKE', '%' . $username . '%');
        }
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if (!is_null($email))
        {
            $query = $query->where('email', 'LIKE', '%' . $email . '%');
        }
        return $query->count('id');
    }
}
