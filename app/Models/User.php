<?php

namespace App\Models;

use DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_photo_url', 'is_admin'];

    public function getIsAdminAttribute(): bool
    {
        return $this->id === 1;
    }

    public function isTeamMember(int $projectId): bool
    {
        return DB::table('project_user')
            ->where('project_id', $projectId)
            ->where('user_id', $this->id)
            ->exists();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function team_projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->with(['category', 'team'])
            ->withCount('todos');
    }

    protected function defaultProfilePhotoUrl()
    {
        return '/storage/profile-photos/' . random_int(1, 7) . '.jpeg';
    }
}
