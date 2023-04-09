<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Hydraulics\MMSHolder;
use Illuminate\Support\Facades\Http;
use App\Models\CampaignContact;
use App\Models\Contact;


class SendAMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $mobile;
    public $message;
    public $image;
    public $cc_id;
    protected $USE_SPECIFIED = 0;
    protected $USE_ALL_DEVICES = 1;
    protected static $USE_ALL_SIMS = 2;
    public $campaignContact;

    public function __construct(CampaignContact $campContact)
    {
        $this->campaignContact = $campContact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaignContact = $this->campaignContact;
        
        
        $contact = Contact::find($campaignContact->contacts_id);
        
        
        $mobile = $contact->mobile;
        $message = $campaignContact->mms_msg;
        $image = $campaignContact->mms_img;

        $array = ['mobile' => $mobile, 'message' => $message, 'image' => $image, 'cc_id' => $campaignContact->id];
        
        

        /*
        if($this->message == '') {
            self::sendSingleMessage($this->mobile, '', 0, null, true, $this->image, false);
        } else if($this->image == '') {
            self::sendSingleMessage($this->mobile, $this->message);
        } */

        /*

        
        

        if($this->cc_id != 0) {
        $contact = CampaignContact::find($this->cc_id);
        $contact->sent = 1; 
        $contact->save();
        
         */
        //}

        //MMSHolder::sendSingleMessage($phone, '', 0, null, true, $imgurl, false);
        //MMSHolder::sendSingleMessage($phone, $contact->mms_msg);
    }

    public static function sendSingleMessage($number, $message, $device = 0, $schedule = null, $isMMS = false, $attachments = null, $prioritize = false)
{
    $url = 'http://198.199.67.139' . "/services/send.php";
    $postData = array(
        'number' => $number,
        'message' => $message,
        'schedule' => $schedule,
        'key' => '98bc4785135b0f45c936540c28b16f48309dcf18',
        'devices' => $device,
        'type' => $isMMS ? "mms" : "sms",
        'attachments' => $attachments,
        'prioritize' => $prioritize ? 1 : 0
    );
    Log::debug('URL is: ');
    Log::debug($url);
    Log::debug('Get variables sent is: ');
    Log::debug($postData);
    return self::sendRequest($url, $postData)["messages"][0];
}

    public static function sendMessages($messages, $option = 0, $devices = [], $schedule = null, $useRandomDevice = false)
{
    $url = env('MMS_Server') . "/services/send.php";
    $postData = [
        'messages' => json_encode($messages),
        'schedule' => $schedule,
        'key' => env('MMS_API_KEY'),
        'devices' => json_encode($devices),
        'option' => $option,
        'useRandomDevice' => $useRandomDevice
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param int    $listID      The ID of the contacts list where you want to send this message.
 * @param string $message     The message you want to send.
 * @param int    $option      Set this to USE_SPECIFIED if you want to use devices and SIMs specified in devices argument.
 *                            Set this to USE_ALL_DEVICES if you want to use all available devices and their default SIM to send messages.
 *                            Set this to USE_ALL_SIMS if you want to use all available devices and all their SIMs to send messages.
 * @param array  $devices     The array of ID of devices you want to use to send the message.
 * @param int    $schedule    Set it to timestamp when you want to send this message.
 * @param bool   $isMMS       Set it to true if you want to send MMS message instead of SMS.
 * @param string $attachments Comma separated list of image links you want to attach to the message. Only works for MMS messages.
 *
 * @return array     Returns The array containing messages.
 * @throws Exception If there is an error while sending messages.
 */
public static function sendMessageToContactsList($listID, $message, $option = 0, $devices = [], $schedule = null, $isMMS = false, $attachments = null)
{
    $url = env('MMS_Server') . "/services/send.php";
    $postData = [
        'listID' => $listID,
        'message' => $message,
        'schedule' => $schedule,
        'key' => env('MMS_API_KEY'),
        'devices' => json_encode($devices),
        'option' => $option,
        'type' => $isMMS ? "mms" : "sms",
        'attachments' => $attachments
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param int $id The ID of a message you want to retrieve.
 *
 * @return array     The array containing a message.
 * @throws Exception If there is an error while getting a message.
 */
public static function getMessageByID($id)
{
    $url = env('MMS_Server') . "/services/read-messages.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'id' => $id
    ];
    return self::sendRequest($url, $postData)["messages"][0];
}

/**
 * @param string $groupID The group ID of messages you want to retrieve.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while getting messages.
 */
public static function getMessagesByGroupID($groupID)
{
    $url = env('MMS_Server') . "/services/read-messages.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'groupId' => $groupID
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param string $status         The status of messages you want to retrieve.
 * @param int    $deviceID       The deviceID of the device which messages you want to retrieve.
 * @param int    $simSlot        Sim slot of the device which messages you want to retrieve. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int    $startTimestamp Search for messages sent or received after this time.
 * @param int    $endTimestamp   Search for messages sent or received before this time.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while getting messages.
 */
public static function getMessagesByStatus($status, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = env('MMS_Server') . "/services/read-messages.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'status' => $status,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param int $id The ID of a message you want to resend.
 *
 * @return array     The array containing a message.
 * @throws Exception If there is an error while resending a message.
 */
public static function resendMessageByID($id)
{
    $url = env('MMS_Server') . "/services/resend.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'id' => $id
    ];
    return self::sendRequest($url, $postData)["messages"][0];
}

/**
 * @param string $groupID The group ID of messages you want to resend.
 * @param string $status  The status of messages you want to resend.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while resending messages.
 */
public static function resendMessagesByGroupID($groupID, $status = null)
{
    $url = env('MMS_Server') . "/services/resend.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'groupId' => $groupID,
        'status' => $status
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param string $status         The status of messages you want to resend.
 * @param int    $deviceID       The deviceID of the device which messages you want to resend.
 * @param int    $simSlot        Sim slot of the device which messages you want to resend. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int    $startTimestamp Resend messages sent or received after this time.
 * @param int    $endTimestamp   Resend messages sent or received before this time.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while resending messages.
 */
public static function resendMessagesByStatus($status, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = env('MMS_Server') . "/services/resend.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'status' => $status,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return self::sendRequest($url, $postData)["messages"];
}

/**
 * @param int    $listID      The ID of the contacts list where you want to add this contact.
 * @param string $number      The mobile number of the contact.
 * @param string $name        The name of the contact.
 * @param bool   $resubscribe Set it to true if you want to resubscribe this contact if it already exists.
 *
 * @return array     The array containing a newly added contact.
 * @throws Exception If there is an error while adding a new contact.
 */
public static function addContact($listID, $number, $name = null, $resubscribe = false)
{
    $url = env('MMS_Server') . "/services/manage-contacts.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'listID' => $listID,
        'number' => $number,
        'name' => $name,
        'resubscribe' => $resubscribe
    ];
    return self::sendRequest($url, $postData)["contact"];
}

/**
 * @param int    $listID The ID of the contacts list from which you want to unsubscribe this contact.
 * @param string $number The mobile number of the contact.
 *
 * @return array     The array containing the unsubscribed contact.
 * @throws Exception If there is an error while setting subscription to false.
 */
public static function unsubscribeContact($listID, $number)
{
    $url = env('MMS_Server') . "/services/manage-contacts.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'listID' => $listID,
        'number' => $number,
        'unsubscribe' => true
    ];
    return self::sendRequest($url, $postData)["contact"];
}

/**
 * @return string    The amount of message credits left.
 * @throws Exception If there is an error while getting message credits.
 */
public static function getBalance()
{
    $url = env('MMS_Server') . "/services/send.php";
    $postData = [
        'key' => env('MMS_API_KEY')
    ];
    $credits = sendRequest($url, $postData)["credits"];
    return is_null($credits) ? "Unlimited" : $credits;
}

/**
 * @param string $request   USSD request you want to execute. e.g. *150#
 * @param int $device       The ID of a device you want to use to send this message.
 * @param int|null $simSlot Sim you want to use for this USSD request. Similar to array index. 1st slot is 0 and 2nd is 1.
 *
 * @return array     The array containing details about USSD request that was sent.
 * @throws Exception If there is an error while sending a USSD request.
 */
public static function sendUssdRequest($request, $device, $simSlot = null)
{
    $url = env('MMS_Server') . "/services/send-ussd-request.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'request' => $request,
        'device' => $device,
        'sim' => $simSlot
    ];
    return self::sendRequest($url, $postData)["request"];
}

/**
 * @param int $id The ID of a USSD request you want to retrieve.
 *
 * @return array     The array containing details about USSD request you requested.
 * @throws Exception If there is an error while getting a USSD request.
 */
public static function getUssdRequestByID($id)
{
    $url = env('MMS_Server') . "/services/read-ussd-requests.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'id' => $id
    ];
    return self::sendRequest($url, $postData)["requests"][0];
}

/**
 * @param string   $request        The request text you want to look for.
 * @param int      $deviceID       The deviceID of the device which USSD requests you want to retrieve.
 * @param int      $simSlot        Sim slot of the device which USSD requests you want to retrieve. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int|null $startTimestamp Search for USSD requests sent after this time.
 * @param int|null $endTimestamp   Search for USSD requests sent before this time.
 *
 * @return array     The array containing USSD requests.
 * @throws Exception If there is an error while getting USSD requests.
 */
public static function getUssdRequests($request, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = env('MMS_Server') . "/services/read-ussd-requests.php";
    $postData = [
        'key' => env('MMS_API_KEY'),
        'request' => $request,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return self::sendRequest($url, $postData)["requests"];
}

/**
 * @return array     The array containing all enabled devices
 * @throws Exception If there is an error while getting devices.
 */
public static function getDevices() {
    $url = env('MMS_Server') . "/services/get-devices.php";
    $postData = [
        'key' => env('MMS_API_KEY')
    ];
    return self::sendRequest($url, $postData)["devices"];
}

public static function sendRequest($url, $postData)
{
    $response = Http::post($url, $postData);
    $httpCode = $response->status();
    if ($httpCode == 200) {
        $json = json_decode($response->body(), true);
        if ($json == false) {
            if (empty($response->body())) {
                throw new \Exception("Missing data in request. Please provide all the required information to send messages.");
            } else {
                throw new \Exception($response->body());
            }
        } else {
            if ($json["success"]) {
                return $json["data"];
            } else {
                throw new \Exception($json["error"]["message"]);
            }
        }
    } else {
        throw new \Exception("HTTP Error Code : {$httpCode}");
    }
}
}
