<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers for the authenticated company
     */
    public function index()
    {
        $company = Auth::user();
        
        $customers = $company->customers()
            ->withCount(['conversations as total_messages' => function ($query) {
                $query->where('direction', 'incoming');
            }])
            ->withCount(['conversations as unread_messages' => function ($query) {
                $query->where('direction', 'incoming')
                      ->where('is_read', false);
            }])
            ->with(['conversations' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('last_contact_at', 'desc')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20|unique:customers,whatsapp_number',
            'email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $company = Auth::user();

        $customer = $company->customers()->create([
            'name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }

    /**
     * Display the specified customer with conversation history
     */
    public function show(Customer $customer)
    {
        $company = Auth::user();
        
        // Ensure the customer belongs to this company
        if ($customer->user_id !== $company->id) {
            abort(403);
        }

        $conversations = $customer->conversations()
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        // Mark all incoming messages as read
        $customer->conversations()
            ->where('direction', 'incoming')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.customers.show', compact('customer', 'conversations'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(Customer $customer)
    {
        $company = Auth::user();
        
        if ($customer->user_id !== $company->id) {
            abort(403);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, Customer $customer)
    {
        $company = Auth::user();
        
        if ($customer->user_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20|unique:customers,whatsapp_number,' . $customer->id,
            'email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $customer->update([
            'name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    /**
     * Remove the specified customer
     */
    public function destroy(Customer $customer)
    {
        $company = Auth::user();
        
        if ($customer->user_id !== $company->id) {
            abort(403);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'تم حذف العميل بنجاح');
    }

    /**
     * Get customer statistics for dashboard
     */
    public function statistics()
    {
        $company = Auth::user();

        $stats = [
            'total_customers' => $company->customers()->count(),
            'active_customers' => $company->customers()->where('status', 'active')->count(),
            'new_customers_today' => $company->customers()
                ->whereDate('created_at', today())
                ->count(),
            'unread_messages' => $company->conversations()
                ->where('direction', 'incoming')
                ->where('is_read', false)
                ->count(),
            'ai_responses_today' => $company->conversations()
                ->where('is_ai_response', true)
                ->whereDate('created_at', today())
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Search customers
     */
    public function search(Request $request)
    {
        $company = Auth::user();
        $query = $request->get('q');

        $customers = $company->customers()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('whatsapp_number', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('company_name', 'like', "%{$query}%");
            })
            ->withCount(['conversations as total_messages' => function ($query) {
                $query->where('direction', 'incoming');
            }])
            ->withCount(['conversations as unread_messages' => function ($query) {
                $query->where('direction', 'incoming')
                      ->where('is_read', false);
            }])
            ->orderBy('last_contact_at', 'desc')
            ->paginate(15);

        return view('admin.customers.index', compact('customers', 'query'));
    }

    /**
     * Export customers data
     */
    public function export(Request $request)
    {
        $company = Auth::user();
        
        $customers = $company->customers()
            ->withCount(['conversations as total_messages' => function ($query) {
                $query->where('direction', 'incoming');
            }])
            ->get();

        // You can implement CSV/Excel export here
        // For now, return JSON
        return response()->json($customers);
    }

    /**
     * Bulk update customer status
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'exists:customers,id',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $company = Auth::user();

        Customer::whereIn('id', $request->customer_ids)
            ->where('user_id', $company->id)
            ->update(['status' => $request->status]);

        return response()->json(['message' => 'تم تحديث حالة العملاء بنجاح']);
    }
}
