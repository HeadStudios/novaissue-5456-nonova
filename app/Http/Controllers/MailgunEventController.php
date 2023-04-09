<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Laravel\Nova\Notifications\NovaNotification;


class MailgunEventController extends Controller
{
    public function handleEvent(Request $request)
    {

        
        $user = User::find(1);
        $user->notify(
            NovaNotification::make()
                ->message('Your report is ready to download.')
                ->action('Download', URL::remote('https://example.com/report.pdf'))
                ->icon('download')
                ->type('info')
        );
        $eventData = $request->input('event-data');
        $email = $eventData['recipient'];
        $event = $eventData['event'];

        $contact = Contact::where('email', $email)->first();

        if (!$contact) {
            return response('Contact not found', 404);
        }

        if ($event === 'opened') {
            $contact->increment('score', 1);
        } elseif ($event === 'clicked') {
            $contact->increment('score', 3);
        }

        return response('OK', 200);
    }
}
