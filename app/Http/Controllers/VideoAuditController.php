<?php

namespace App\Http\Controllers;
use App\Models\VideoAudit;
use Illuminate\Http\Request;
use App\Notifications\NowYouKnow;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Notification;


class VideoAuditController extends Controller
{
    public function show($slug)
    {
        $audit = VideoAudit::where('permalink', $slug)->first();
        if ($audit) {

            //$invoice = new ZohoInvoice();

            return view('video-audit-single', [
                'audit' => $audit
            ]);
        }

        // No match was found
        abort(404);
    }
}
