<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

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

    /**
     * userが所有する投稿を取得する。(一対多のリレーション)
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * userが所有するコメントを取得する。(一対多のリレーション)
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * userがsoft deleteされたときに、関連するpostをsoft deleteする
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->posts()->delete();
            $user->comments()->delete();
        });
    }

}
