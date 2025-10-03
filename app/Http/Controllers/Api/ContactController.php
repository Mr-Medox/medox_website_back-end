<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Store a newly created contact message.
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
            'project_type' => $request->project_type,
            'budget' => $request->budget,
            'timeline' => $request->timeline,
            'source' => 'website',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
            'utm_source' => $request->utm_source,
            'utm_medium' => $request->utm_medium,
            'utm_campaign' => $request->utm_campaign,
        ]);

        // Send email notifications
        $this->emailService->sendContactNotification($contact);
        $this->emailService->sendContactConfirmation($contact);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you soon.',
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
            ]
        ], 201);
    }

    /**
     * Get contact statistics for admin.
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::status('new')->count(),
            'read' => Contact::status('read')->count(),
            'replied' => Contact::status('replied')->count(),
            'closed' => Contact::status('closed')->count(),
            'this_month' => Contact::whereMonth('created_at', now()->month)->count(),
            'this_week' => Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
