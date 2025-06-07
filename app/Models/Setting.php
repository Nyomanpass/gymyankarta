<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
    ];

    // helper method untuk mengambil nilai setting
    public static function get($key, $default = null)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    //helper method untuk mengset nilai setting
    public static function set($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'description' => $description
            ]
        );
    }

    //helper methods untuk setting khusus
    public static function getMembershipFee()
    {
        return self::get('membership_fee', 0);
    }

    public static function getDailyVisitFee()
    {
        return self::get('daily_visit_fee', 0);
    }
}
