<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Employee;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'user_type',
        'role_id',
        'remember_token',
        'user_token'
    ];

       public function employee()
        {
            return $this->hasOne(Employee::class);
        }

        public function role()
        {
            return $this->belongsTo(Role::class);
        }

         // ✅ Direct permission check (BEST PRACTICE)
    public function hasPermission($permission)
    {
        // Super Admin full access
        if ($this->role_id == 1) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()
            ->where('name', $permission)
            ->exists();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
