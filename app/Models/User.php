<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'nama_lengkap',
        'no_wa',
        'alamat',
        'foto_profile',
    ];

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    /**
     * Get the user's profile photo URL or default avatar initials.
     *
     * @return string
     */
    public function getFotoProfileUrlAttribute()
    {
        if ($this->foto_profile && Storage::disk('public')->exists($this->foto_profile)) {
            return asset('storage/' . $this->foto_profile);
        }

        $name = !empty(trim($this->nama_lengkap ?? '')) ? $this->nama_lengkap : $this->username;
        $name = trim($name);

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=bfa28c&color=ffffff&bold=true&length=2';
    }

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**

     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
