<?php

namespace App;

use DB;
use Eloquent;

use Illuminate\Notifications\Notifiable;
use Savannabits\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
    }
    use Notifiable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	protected $with = ["type"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * Get the profile associated with the user.
     */
    public function levels()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
	
	/**
     * Get type of Doctor.
     */
    public function type()
    {
        return $this->belongsTo('App\Specialization', 'type');
    }
	
	/**
     * 
     */
    public function referto()
    {
       return $this->hasMany('App\Refer', 'refer_to');
    }
	
	/**
     * 
     **/
    public function referby()
    {
       	return $this->hasMany('App\Refer', 'refer_by');
    }
	
	/**
	*
	**/
}


