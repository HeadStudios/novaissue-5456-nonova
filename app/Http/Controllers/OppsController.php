<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use PDF;

class OppsController extends Controller
{
    protected $access_token;
    protected $headers;
    protected $org_id;

    public static function doMe() {
        $imgurl = \Storage::disk('s3')->url('iywHgix0fFxCMqxgbhJRsc3fDnMD4h5G870HP3rs.png');
        \Storage::disk('s3')->put('images/dobaba.png', file_get_contents($imgurl));
    }

    public function homie() {
        $parsedown = new \Parsedown();
        
        $url = 'https://accounts.zoho.com/oauth/v2/token?refresh_token='.env('zoho_refresh_token').'&client_id='.env('zoho_client_id').'&client_secret='.env('zoho_client_secret').'&redirect_uri=http://www.zoho.com/books&grant_type=refresh_token';

        $response = Http::post($url);

        $response = json_decode($response,true);

        $this->access_token = $response['access_token'];

        $this->headers = [
            'Authorization' => 'Zoho-oauthtoken '.$this->access_token,
            'Content-Type' => 'application/json'
        ];

        $this->org_id = $this->getID();

        $html = '<h1 style="color:red;">Hello World</h1>';
        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        //PDF::Output();
        //$contents = \Storage::disk('s3')->get('https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg');
        
        \Storage::disk('s3')->put('images/baby.pdf', PDF::Output('baby.pdf', 'S'));

        $imgurl = \Storage::disk('s3')->url('iywHgix0fFxCMqxgbhJRsc3fDnMD4h5G870HP3rs.png');
        \Storage::disk('s3')->put('images/babablacksheep.png', file_get_contents($imgurl));

        //PDF::Output('hello_world.pdf');

        return 'Are you there?';

        //return 'I have a refresh token, andAccess Token is: '.$response['access_token'].' and the response is.and the ID of the org is: '.$this->org_id;
    }

    function getID() {

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken '.$this->access_token,
            'Content-Type' => 'application/json'
        ])->get('https://books.zoho.com/api/v3/organizations');
        $response = json_decode($response,true);
        return $response['organizations'][1]['organization_id'];
    }

    public static function doIt() {
        $response = Http::post('https://webhook.site/7058c084-b629-4f76-bd4e-d42e856339fb', [
            'Value' => 'Controller Called',
            'Now' => 'Awake',
            'Position' => 'Inside controller'
        ]);
    }

}
