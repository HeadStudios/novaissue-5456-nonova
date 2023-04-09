<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use PDF;


class ZohoInvoice {

    public $access_token = '';
    protected $client;
    protected $auth;
    protected $headers;
    public $org_id;
    

    function __construct() {

        $url = 'https://accounts.zoho.com/oauth/v2/token?refresh_token='.env('zoho_refresh_token').'&client_id='.env('zoho_client_id').'&client_secret='.env('zoho_client_secret').'&redirect_uri=http://www.zoho.com/books&grant_type=refresh_token';
        
        $response = Http::post($url);

        $response = json_decode($response,true);

        $this->access_token = $response['access_token'];

        dump("Access token to play with is: ".$this->access_token);

        $this->headers = [
            'Authorization' => 'Zoho-oauthtoken '.$this->access_token,
            'Content-Type' => 'application/json'
        ];

        $this->org_id = $this->getID();
        
    }

    function cleanseFormidableArray(array $input) {
        unset($input['form']);
        $input = array_values($input);
        return $input;
    }

    function getID() {
        /*$response = Http::withHeaders($this->headers)->get('https://books.zoho.com/api/v3/organizations');
        $response = json_decode($response,true);
        return $response['organizations'][1]['organization_id'];*/
        return env('zoho_org');
    }

    function getContacts() {
        if(!isset($this->org_id)) {  return false; } //throw new Exception("Please set the org_id variable before calling getContacts function"); }
            $url = 'https://books.zoho.com/api/v3/contacts?organization_id='.$this->org_id;
            $response = Http::withHeaders($this->headers)->get($url);
            $response = json_decode($response,true);
            return $response;

    }

    function getContactIDByEmail(string $email)  {

        $contacts = $this->getContacts();
        $key = array_search($email, array_column($contacts['contacts'], 'email'));

        if($key == false) { return false; } //throw new Exception("No contact with the email: ".$mail); }
        $id = $contacts['contacts'][$key]['contact_id'];
        return $id;
    }

    function getContactIDByName(string $contact_name)  {

        $contacts = $this->getContacts();

        $key = array_search($contact_name, array_column($contacts['contacts'], 'contact_name'));

        if($key == false) { return false; } //throw new Exception("No contact with the email: ".$mail); }
        $id = $contacts['contacts'][$key]['contact_id'];
        return $id;
    }

    function createContact($name, $email, $company, $website) {

        $url = 'https://books.zoho.com/api/v3/contacts?organization_id='.$this->org_id;

        $json = [
            'contact_name' => $name,
            'company_name' => $company,
            'website' => $website,
            'contact_type' => 'customer',
            'payment_terms' => 0
        ]; 

        

        $response = Http::withHeaders($this->headers)->post($url, $json);
        $array = json_decode($response, true);

        return $array['contact']['contact_id'];

    }

    function createInvoiceDraft(array $line_items, $customer_id, $recurring = false) {
        // if(!isset($line_items[0]['name'])||!isset($line_items[0]['description'])||!isset($line_items[0]['rate'])||!isset($line_items[0]['quantity'])) { throw new Exception("Please check line_items argument of createInvoiceDraft has name, description, rate and quantity keys"); }
        if (!isset($customer_id)) {
            return false;
            ray('Customer ID is not even there');
        } //throw new Exception("Customer ID is not set to create Draft Invoice"); }
    
        $data = [
            'customer_id' => $customer_id,
            'line_items' => $line_items
        ];
    
        if ($recurring) {
            $url = 'https://www.zohoapis.com/books/v3/recurringinvoices?organization_id=' . $this->org_id;
            $recurrence_name = 'recurring_' . $customer_id . '_' . uniqid();
            $data['recurrence_name'] = $recurrence_name;
            $data['recurrence_frequency'] = 'months';
        } else {
            $url = 'https://books.zoho.com/api/v3/invoices?organization_id=' . $this->org_id;
        }
    
        dump("The data we're passing is: ");
        dump($data);
        $response = Http::withHeaders($this->headers)->post($url, $data);

        dump("The response from my attempts are as follows: ");
        dump($response->body());
        $array = json_decode($response, true);
    
        if ($recurring) {
            $id = $array['recurring_invoice']['recurring_invoice_id'];
        } else {
            $id = $array['invoice']['invoice_id'];
        }
        return $id;
    }

    // Create a Laravel eloquent query that gets all courses that have users attached filtered by users that are active

    function lineItemParser($line_items) {

        $line_items = $this->cleanseFormidableArray($line_items);
        
        $finished_line_items = [];
        foreach($line_items as $line_item) {

            if($line_item['productname']) {
                $key = array_search($line_item['productname'], array_column($line_items, 'productname'));
            } else {
            $key = array_search($line_item['name'], array_column($line_items, 'name')); }

            if(!isset($line_item['item_id'])) {
                //$line_items[$key]['item_id'] = '20028000001168016';
                $line_items[$key]['item_id'] = '451794000000571001';
            }
            if(!isset($line_item['rate'])) {
                //$line_items[$key]['item_id'] = '20028000001168016';
                $line_items[$key]['rate'] = 500;
            }
            if(!isset($line_item['quantity'])) {
                //$line_items[$key]['item_id'] = '20028000001168016';
                $line_items[$key]['quantity'] = 1;
            }
            if(isset($line_item['productname'])) {
                $line_items[$key]['name'] = $line_item['productname'];
                //try {
                unset($line_items[$key]['productfeature']);
                $line_items[$key]['description'] = $line_item['productfeature'];
                //} catch(Exception $e) {
                //    throw new Exception("Check to make sure ProductFeature and ProductBenefit is set");
                //}

            }
            
        }

        return $line_items;
    }

    function getAndSaveInv($inv_id) {
        
        //$directory = $save_path;
        $url = 'https://books.zoho.com/api/v3/invoices/'.$inv_id.'?organization_id=637404798&accept=pdf&print=true';
        $auth = 'Zoho-oauthtoken '.$this->access_token;
        $file = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $auth
        ])->get($url);
        return $file;

    }

    function getChildInvoices($recurring_invoice_id)
{
    $url = 'https://books.zoho.com/api/v3/recurringinvoices/' . $recurring_invoice_id . '/invoices?organization_id=' . env('zoho_org');

    $response = Http::withHeaders($this->headers)->get($url);
    $data = json_decode($response->body(), true);

    if (isset($data['invoice_history'])) {
        return $data['invoice_history'];
    }

    return [];
}

    function formExists($form_id) {
        /*
        $qry = "SELECT * FROM `forms` WHERE form_id = ".$form_id;
        $results = DB::query($qry);
        if(empty($results)) { 
    
            $query = "INSERT INTO defaultdb.forms (form_id) VALUES ('".$form_id."')";
            echo "results are empty - fromt eh formExists function";
            DB::query($query);
    
            return false; } 
            else { return true; } */
            return false; 
    
    }

}