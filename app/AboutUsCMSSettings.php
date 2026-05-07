<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUsCMSSettings extends Model
{
    protected $primaryKey = 'id';
    public $table = 'about_us_c_m_s_settings';
    protected $casts = [
        'who_content' => 'array',
        'what_items' => 'array',
        'core_values' => 'array',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public static function defaults()
    {
        return [
            'banner_title' => 'About Us',
            'banner_image' => 'assets/img/baner/1.jpg',
            'who_title' => 'Who We Are',
            'who_image' => 'assets/img/ab3.jpg',
            'who_content' => [
                'Hita Soft Systems is a specialized engineering firm based in Thiruvananthapuram, Kerala, focused on the design and manufacturing of embedded software-controlled automation systems, particularly for water pump management',
                'Founded and led by CS Rajan Babu, Design Engineer, the company combines strong technical expertise with practical innovation to deliver reliable, efficient, and cost-effective solutions for residential, commercial, and industrial applications.',
                'With a deep understanding of real-world challenges in water management and electrical systems, we develop products that ensure automation, safety, and long-term performance.',
            ],
            'what_title' => 'What We Do',
            'what_content' => 'We design and manufacture advanced control panel systems that automate and protect water pumping operations. Our solutions are built with intelligent features such as',
            'what_items' => [
                'Water level sensing automation',
                'Dry run protection',
                'Overload safety',
                'High/low voltage protection',
                'Phase failure and sequence protection',
                'Timer-based operation control',
            ],
            'what_image' => 'assets/img/ab2.jpg',
            'mission_title' => 'Our Mission',
            'mission_content' => 'To deliver innovative, reliable, and energy-efficient automation solutions through advanced embedded technology, ensuring safety, convenience, and long-term value for our customers.',
            'vision_title' => 'Our Vision',
            'vision_content' => 'To become a trusted leader in embedded automation systems by continuously innovating and providing high-quality engineering solutions that enhance everyday life and industrial efficiency.',
            'core_values_title' => 'Our Core Values',
            'core_values' => [
                ['title' => 'Innovation', 'description' => 'Continuously improving and adopting new technologies'],
                ['title' => 'Quality', 'description' => 'Delivering durable and reliable products'],
                ['title' => 'Integrity', 'description' => 'Transparent and ethical business practices'],
                ['title' => 'Customer Focus', 'description' => 'Understanding and fulfilling customer needs'],
                ['title' => 'Excellence', 'description' => 'Commitment to engineering precision and performance'],
            ],
            'leadership_bg_image' => 'assets/img/ab4.jpg',
            'leadership_label' => 'Leadership',
            'leadership_name' => 'CS Rajan Babu',
            'leadership_designation' => 'Owner & Design Architect | Design Engineer',
            'leadership_content' => 'With extensive experience in embedded systems and automation, he leads the company with a strong focus on technical excellence and product innovation.',
            'presence_label' => 'Our Presence',
            'presence_name' => 'Hita Soft Systems',
            'presence_address' => "TC 49/20-1\nPamamcode, Pappanamcode\nIndustrial Estate PO\nThiruvananthapuram, Kerala - 695019\nIndia",
            'presence_phone' => '+91-9387737998',
            'presence_email' => 'hitasoftsystems@gmail.com',
        ];
    }
}
