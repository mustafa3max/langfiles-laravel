<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class LF
{
    static private $keys = [];
    static public $strings = [];
    static $stringsOnline = [];

    static function initStrings()
    {
        $api = "https://langfiles.com/api/keys-values";

        $response = Http::post($api, [
            "lang" => App::currentLocale(),
            "all_key" => self::$keys
        ]);

        self::$stringsOnline = $response->json();
    }

    static function init()
    {
        self::initStrings();
        foreach (self::$keys as $key) {
            try {
                self::$strings[$key] = self::$stringsOnline[$key];
            } catch (\Throwable $th) {
                self::$strings[$key] = $key;
            }
        }
    }

    static function str(String $key)
    {
        self::$keys[] = $key;

        try {
            return self::$strings[$key];
        } catch (\Throwable $th) {
            return $key;
        }
    }

    static function ready()
    {
        self::init();

        return self::$strings;
    }
}
