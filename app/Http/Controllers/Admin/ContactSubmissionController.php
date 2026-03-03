<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::latest();

        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(20)->withQueryString();
        $unreadCount = ContactSubmission::where('is_read', false)->count();

        return view('admin.super.contact-submissions.index', compact('submissions', 'unreadCount'));
    }

    public function show(ContactSubmission $contactSubmission)
    {
        if (! $contactSubmission->is_read) {
            $contactSubmission->markAsRead();
        }

        return view('admin.super.contact-submissions.show', compact('contactSubmission'));
    }

    public function markRead(ContactSubmission $contactSubmission)
    {
        $contactSubmission->markAsRead();

        return back()->with('success', 'Marked as read.');
    }

    public function markUnread(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update(['is_read' => false, 'read_at' => null]);

        return back()->with('success', 'Marked as unread.');
    }

    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()
            ->route('admin.contact-submissions.index')
            ->with('success', 'Submission deleted.');
    }
}
