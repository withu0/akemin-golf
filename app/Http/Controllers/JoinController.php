<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationAdminNotification;
use App\Mail\ApplicationAutoReply;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class JoinController extends Controller
{
    public function create()
    {
        return Inertia::render('Join', [
            'image' => media_url('media/la-round.jpg'),
        ]);
    }

    public function store(string $locale, Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['nullable', 'email', 'max:160'],
            'country'  => ['nullable', 'string', 'max:120'],
            'interest' => ['nullable', 'string', 'max:60'],
            'message'  => ['nullable', 'string', 'max:3000'],
        ]);

        $data['locale'] = app()->getLocale();

        $application = Application::create($data);

        $this->sendApplicationEmails($application);

        return redirect()->route('join')->with('joined', true);
    }

    private function sendApplicationEmails(Application $application): void
    {
        try {
            if (filled($application->email)) {
                Mail::to($application->email)->send(new ApplicationAutoReply($application));
            }

            $adminEmail = config('site.admin_email');
            if (filled($adminEmail)) {
                Mail::to($adminEmail)->send(new ApplicationAdminNotification($application));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send join application emails.', [
                'application_id' => $application->id,
                'message'        => $e->getMessage(),
                'exception'      => $e::class,
            ]);
            report($e);
        }
    }
}
