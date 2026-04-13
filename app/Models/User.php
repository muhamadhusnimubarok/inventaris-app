<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

 public function generateDefaultPassword()
{
    $prefix = substr($this->email, 0, 4);
    $id = $this->id ?? ((\App\Models\User::max('id') ?? 0) + 1);
    return $prefix . $id;
}

protected static function booted()
{
    static::creating(function ($user) {
        $prefix = substr($user->email, 0, 4);
        $nextId = (\App\Models\User::max('id') ?? 0) + 1;
        $plainPassword = $prefix . $nextId;

        $user->password = bcrypt($plainPassword);
        $user->is_password_modified = false;
        session()->flash('generated_password', $plainPassword);
    });
}


    public function lendings(): HasMany { return $this->hasMany(Lending::class);}
}
