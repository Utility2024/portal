<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Filament\Models\Contracts\FilamentUser;
use Tapp\FilamentInvite\Notifications\SetPassword;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Edwink\FilamentUserActivity\Traits\UserActivityTrait;
use BetterFuturesStudio\FilamentLocalLogins\Concerns\HasLocalLogins;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class User extends Authenticatable implements FilamentUser, Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPanelShield, UserActivityTrait, HasLocalLogins,\OwenIt\Auditing\Auditable;

    const ROLE_ADMIN = 'ADMIN';

    const ROLE_EDITOR = 'EDITOR';

    const ROLE_USER = 'USER';

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_USER => 'User',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'role',
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


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isEditor() || $this->isUser();
    }

    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(){
        return $this->role === self::ROLE_EDITOR;
    }

    public function isUser(){
        return $this->role === self::ROLE_USER;
    }


}
