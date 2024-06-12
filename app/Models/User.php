<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'last_seen',
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
    protected $appends = ['onlineStatus'];

    //questions
    public function question()
    {
        return $this->hasMany(Question::class,'user_id','id');
    }

    //comment
    public function comment()
    {
        return $this->hasMany(QuestionComment::class,'user_id','id');
    }

    //user online check
    public function userOnlineCheck()
    {
        if(Cache::has('user-is-online-' . $this->id))
        {
            return 'online';
        }else
        {
            return Carbon::parse($this->last_seen)->diffForHumans();
        }
    }

    //added online status to user
    public function getOnlineStatusAttribute()
    {
        return $this->userOnlineCheck();
    }
}
