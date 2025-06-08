<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 一括代入可能な属性
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    /**
     * Commentを所有するユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Commentを所有する投稿を取得する
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
