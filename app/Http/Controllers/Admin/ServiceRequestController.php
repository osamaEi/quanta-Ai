<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of service requests
     */
    public function index()
    {
        $pendingRequests = User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })
        ->whereJsonContains('ai_settings->status', 'pending')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $approvedRequests = User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })
        ->whereJsonContains('ai_settings->status', 'approved')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $rejectedRequests = User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })
        ->whereJsonContains('ai_settings->status', 'rejected')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.service-requests.index', compact('pendingRequests', 'approvedRequests', 'rejectedRequests'));
    }

    /**
     * Show the form for reviewing a service request
     */
    public function show(User $user)
    {
        // Ensure the user is a company
        if (!$user->roles()->where('name', 'company')->exists()) {
            abort(404);
        }

        return view('admin.service-requests.show', compact('user'));
    }

    /**
     * Approve a service request
     */
    public function approve(Request $request, User $user)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Update user status to approved
        $aiSettings = $user->ai_settings ?? [];
        $aiSettings['status'] = 'approved';
        $aiSettings['approved_at'] = now();
        $aiSettings['approved_by'] = auth()->id();
        $aiSettings['admin_notes'] = $request->admin_notes;

        $user->update([
            'ai_settings' => $aiSettings,
        ]);

        // Send approval email to user
        $this->sendApprovalEmail($user, $request->admin_notes);

        return redirect()->route('admin.service-requests.index')
            ->with('success', 'Service request approved successfully');
    }

    /**
     * Reject a service request
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        // Update user status to rejected
        $aiSettings = $user->ai_settings ?? [];
        $aiSettings['status'] = 'rejected';
        $aiSettings['rejected_at'] = now();
        $aiSettings['rejected_by'] = auth()->id();
        $aiSettings['rejection_reason'] = $request->rejection_reason;

        $user->update([
            'ai_settings' => $aiSettings,
        ]);

        // Send rejection email to user
        $this->sendRejectionEmail($user, $request->rejection_reason);

        return redirect()->route('admin.service-requests.index')
            ->with('success', 'Service request rejected successfully');
    }

    /**
     * Send approval email to user
     */
    private function sendApprovalEmail(User $user, $notes = null): void
    {
        // You can implement custom email template here
        // Mail::to($user->email)->send(new ServiceRequestApprovedMail($user, $notes));
        
        \Log::info('Approval email sent to: ' . $user->email . ' for company: ' . $user->company_name);
    }

    /**
     * Send rejection email to user
     */
    private function sendRejectionEmail(User $user, $reason): void
    {
        // You can implement custom email template here
        // Mail::to($user->email)->send(new ServiceRequestRejectedMail($user, $reason));
        
        \Log::info('Rejection email sent to: ' . $user->email . ' for company: ' . $user->company_name . ' with reason: ' . $reason);
    }

    /**
     * Get service request statistics
     */
    public function statistics()
    {
        $stats = [
            'total_requests' => User::whereHas('roles', function ($query) {
                $query->where('name', 'company');
            })->count(),
            'pending_requests' => User::whereHas('roles', function ($query) {
                $query->where('name', 'company');
            })->whereJsonContains('ai_settings->status', 'pending')->count(),
            'approved_requests' => User::whereHas('roles', function ($query) {
                $query->where('name', 'company');
            })->whereJsonContains('ai_settings->status', 'approved')->count(),
            'rejected_requests' => User::whereHas('roles', function ($query) {
                $query->where('name', 'company');
            })->whereJsonContains('ai_settings->status', 'rejected')->count(),
        ];

        return response()->json($stats);
    }
}
