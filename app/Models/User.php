<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    public function sentContacts()
    {
        return $this->belongsToMany(User::class ,'contacts','adder_id','added_id');
    }
    public function receivedContacts()
    {
        return $this->belongsToMany(User::class ,'contacts','added_id','adder_id');
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class,'sender_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class,'receiver_id');
    }
    public function getConversation($id){
        /*$messages=DB::table('messages')->where([['sender_id',$this->id],['receiver_id',$id]])
        ->orwhere([['sender_id',$id],['receiver_id',$this->id]])->get();*/
        $messages=Message::where([['sender_id',$this->id],['receiver_id',$id]])
        ->orwhere([['sender_id',$id],['receiver_id',$this->id]])->get();
        return $messages;
    }


}
