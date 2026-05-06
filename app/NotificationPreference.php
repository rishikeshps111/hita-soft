<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    protected $primaryKey = 'id';
    public $table = 'notification_preferences';
    protected $fillable = [
        'user_id',
        'order_related',
        'newsletter_updates',
        'news_items',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
