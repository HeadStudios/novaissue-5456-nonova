<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use PDF;


class Shorter {

    public static function ImHere($domain, $path) {
        $headers = [
            'Authorization' => 'sk_7D26vBocMbHyPvUL',
            'Content-Type' => 'application/json'
        ];
        $response = Http::withHeaders($headers)->get('https://api.short.io/links/expand', [
            'domain' => 'showme.headstudios.com.au',
            'path' => 'Fakes-terminator917'
        ])['idString'];
        return $response;
    }

    public static function Parser($url) {
        return parse_url($url);
    }

}