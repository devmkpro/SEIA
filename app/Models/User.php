<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $table = 'users';


    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
            $model->username = $model->createUsername();
        });
    }

    /**
     * Create Username for User
     */
    public function createUsername(): string
    {
        $username = date('dmY') . substr($this->uuid, -4);
        $user = User::where('username', $username)->first();
        if ($user) {
            $this->createUsername();
        }
        return $username;
    }
    /**
     * Get the datauser associated with the user.
     */

    public function datauser()
    {
        return $this->hasOne(DataUser::class);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'phone',
        'name',
        'photo',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * Get Schools associated with the user.
     */
    public function schools()
    {

        return $this->belongsToMany(School::class, 'users_schools', 'users_uuid', 'school_uuid')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get school associated with the user.
     */
    public function schoolAssociated($schoolUUID)
    {
        $school = School::where('uuid', decrypt($schoolUUID))->first();
        if (!$school) {
            return null;
        } elseif ($this->hasRole('admin')) {
            return 'admin';
        }

        return $this->schools()->where('school_uuid', $schoolUUID)->first()->pivot->role;
    }


    /**
     * Assign a role to a user for a school.
     */

    public function assignRoleForSchool($role, $schoolUUID)
    {
        if (!$schoolUUID || !$role) {
            return;
        }
        $role = Role::where('name', $role)->first();
        $this->schools()->syncWithoutDetaching([
            $schoolUUID => [
                'uuid' => Str::uuid()->toString(),
                'role' => $role->uuid
            ]
        ]);
    }

    /**
     * Revokes a role from a user for a school.
     */
    public function revokeRoleForSchool($schoolUUID)
    {
        $this->schools()->updateExistingPivot($schoolUUID, ['role' => null]);
    }

    /**
     * Remove relationship between user and school.
     */
    public function removeSchool($schoolUUID)
    {
        $this->schools()->detach($schoolUUID);
    }

    /**
     * Check if a user has a role for a school.
     */

    public function hasRoleForSchool($role, $schoolUUID)
    {
        $role = Role::where('name', $role)->first();
        return $this->schools()->where('school_uuid', $schoolUUID)->wherePivot('role', $role->uuid)->exists();
    }

    /**
     * Check if a user has a permission for a school.
     */

    public function hasPermissionForSchool($permission, $schoolUUID)
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        $school = School::where('uuid', $schoolUUID)->first();
        if (!$school || !$this->schools()->where('school_uuid', $schoolUUID)->first()) {
            return false;
        }

        $roleID = $this->schools()->where('school_uuid', $schoolUUID)->first()->pivot->role;
        $role = Role::where('uuid', $roleID)->first();

        if (!$this->hasRoleForSchool($role->name, $schoolUUID)) {
            return false;
        }

        return $this->hasPermission($permission, $role);
    }

    /**
     * Check if a user has a permission for a role.
     */
    public function hasPermission($permission, Role $role)
    {
        $permissions = $role->permissions;
        if ($permissions->contains('name', $permission) || $this->hasRole('admin')) {
            return true;
        }
        return false;
    }

  
}
