<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 2/17/19
 * Time: 12:28 AM
 */
namespace Devert\Util;
class Command
{
    private static $arguments = [
        'csv',
        'xls'
    ];

    public static function handle() {
        if(count($_SERVER['argv']) > count(self::$arguments)) {
            throw new \InvalidArgumentException('Too many arguments');
        }
    }

    public function xmlToObject() : \stdClass {

    }
}