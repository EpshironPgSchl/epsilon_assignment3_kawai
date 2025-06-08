<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    //一括代入可能な属性
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * Postが所有するコメントを取得する。(一対多のリレーション)
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Postを所有するユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * postがsoft deleteされたときに、関連するコメントもsoft deleteする
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($post) {
            $post->comments()->delete();
        });
    }

}
