<?php 

namespace App;

use DateTime;

class DateHelper 
{
    /**
     * Gets how many days it has been since the given date.
     * Credit: https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
     */
    public static function getDaysSince($dateTime, $full = false)
    {
        $dateTime = new DateTime($dateTime);
        $today = new DateTime();
        $diff = $today->diff($dateTime);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        );

        foreach ($string as $k => &$v)
        {
            if ($diff->$k)
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            else 
                unset($string[$k]);
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string). ' ago.' : 'Just now.';
    }
}