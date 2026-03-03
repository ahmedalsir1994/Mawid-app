<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactConfirmationMail;
use App\Mail\ContactSubmissionMail;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Notifications\NewContactSubmissionNotification;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        // Save submission
        $submission = ContactSubmission::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        // Email notification to admin inbox
        try {
            Mail::to('ahmedsecret94@gmail.com')
                ->send(new ContactSubmissionMail($submission));
        } catch (\Throwable $e) {
            logger()->error('ContactSubmissionMail failed: ' . $e->getMessage());
        }

        // Confirmation email to the submitter
        try {
            Mail::to($submission->email)->send(new ContactConfirmationMail($submission));
        } catch (\Throwable $e) {
            logger()->error('ContactConfirmationMail failed: ' . $e->getMessage());
        }

        // Database notification to all super admins
        $superAdmins = User::where('role', 'super_admin')->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new NewContactSubmissionNotification($submission));
        }

        return redirect()
            ->route('contact')
            ->with('success', __('contact.form_success'));
    }
}
