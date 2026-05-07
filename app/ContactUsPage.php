<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsPage extends Model
{
    protected $primaryKey = 'id';
    public $table = 'contact_us_page';
    protected $hidden = [
        'created_at','updated_at'
    ];

    public static function defaults()
    {
        return [
            'banner_title' => 'Contact Us',
            'banner_image' => 'assets/img/baner/2.jpg',
            'form_intro' => "Please complete the form below. We'll do everything we can to respond to you as quickly as possible.",
            'address' => "TC 49/20-1 Pamamcode, Pappanamcode Industrial Estate PO Thiruvananthapuram, Kerala - 695019 India",
            'email' => 'hitasoftsystems@gmail.com',
            'phone' => '+91-9387737998',
            'map_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.3111668607303!2d77.0014897747738!3d8.469091891571589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bb00115a96cf%3A0xbdbab5ca7c70fa2a!2sHita%20Soft%20Systems!5e0!3m2!1sen!2sin!4v1777365749512!5m2!1sen!2sin',
        ];
    }
}
