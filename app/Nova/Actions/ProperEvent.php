<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use App\Models\ScheduledEmail;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Firebase\JWT\JWT;
use App\Mail\MyMailGun;


// Google API Client
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class ProperEvent extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $contact = $models[0]->contact;

        dump("The contact is....");
        dump($contact);
        dump("And the timezone is...");
        dump($contact->timezone);

        // Check if the user is authenticated with Google
    if (!session()->has('google_access_token')) {
        return Action::danger('You are not authenticated with Google.');
    }

    $jwtToken = $this->generateZoomJWTToken(env('ZOOM_API'),env('ZOOM_SECRET'));

    $url = 'https://api.zoom.us/v2/users/me/meetings';
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $jwtToken,
    ];

    dump("The field passed for start_time is: ");
    dump($fields->start_time);
    $inputDateTime = substr($fields->start_time, 0, 19);
    $startTime = Carbon::parse($inputDateTime, $contact->timezone);

    dump("The start time with the new timezone parsed format is: ");
    dump($startTime->format('Y-m-d\TH:i:s\Z'));

    $body = [
        'topic' => 'Rent Roll Accleration Meeting',
        'type' => 2,
        'start_time' => $startTime->format('Y-m-d\TH:i:s\Z'),
        'duration' => 30,
        'timezone' => 'UTC',
        'settings' => [
            'join_before_host' => true,
            'waiting_room' => false,
        ],
    ];

    $response = Http::withHeaders($headers)->post($url, $body);

    if ($response->successful()) {
        $meetingDetails = $response->json();
        $joinUrl = $meetingDetails['join_url'];
    } else {
        // Handle errors and exceptions
        return Action::danger('An error occurred while creating the Zoom meeting.');
    }

    // Initialize the Google Client
    $client = new Google_Client();
    $client->setAccessToken(session('google_access_token'));

    // Create a new event
    $calendarService = new Google_Service_Calendar($client);

    // Calculate the end time by adding 30 minutes to the start time
    $endTime = $startTime->copy()->addMinutes(30);

    $event = new Google_Service_Calendar_Event([
        'summary' => 'Rent Roll Accelration Meeting',
        'location' => 'Zoom Zoom',
        'description' => 'Discuss implementation of a video content auto-follow up system in your business. Join here: '.$joinUrl,
        'start' => new Google_Service_Calendar_EventDateTime([
            'dateTime' => $startTime->format('c'),
            'timeZone' => $contact->timezone,
        ]),
        'end' => new Google_Service_Calendar_EventDateTime([
            'dateTime' => $endTime->format('c'),
            'timeZone' => $contact->timezone,
        ]),
        'attendees' => [
            ['email' => $contact->email],
        ],
    ]);

    $event->setDescription("Discuss implementation of a video content auto-follow up system in your business.\n\n Zoom Join here: {$joinUrl}");


    $calendarId = 'primary';
    $createdEvent = $calendarService->events->insert($calendarId, $event, ['sendUpdates' => 'all']);

    $fields = [];
        
        $fields['subject'] = 'Rent Roll Acceleration Meeting';
        $fields['intro_text'] = 'This is some intro text to confirm fields are going through';
        $fields['start_time'] = $startTime->format('l, jS F \a\t g:ia');
        $fields['timezone'] = $contact->timezone;
        $scheduledEmail = new ScheduledEmail();
        $scheduledEmail->contact_id = $contact->id;
        $scheduledEmail->message = 'Nothing to change';
        dump("So the fields passed to scheduled mail are...");
        dump($fields);
        $scheduledEmail->fields = $fields;
        $scheduledEmail->template = 'emails.templates.meeting-confirm';
        $scheduledEmail->scheduled_at = now()->subMinutes(5);
        $scheduledEmail->save();

    return Action::message('The event has been created successfully.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            DateTime::make('Event Start Time', 'start_time')->required(),
        ];
    }

    public function generateZoomJWTToken($apiKey, $apiSecret)
  {
      $payload = [
          'iss' => $apiKey,
          'exp' => time() + 3600, // Expires in 1 hour
      ];
  
      return JWT::encode($payload, $apiSecret, 'HS256');
  }
}
