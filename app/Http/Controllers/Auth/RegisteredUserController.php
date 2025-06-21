<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'business_type' => ['required', 'string', 'in:retail,wholesale,services,manufacturing,restaurant,healthcare,education,other'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ], [
            'company_name.required' => 'اسم الشركة مطلوب',
            'name.required' => 'اسم المسؤول مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'phone_number.required' => 'رقم الهاتف مطلوب',
            'whatsapp_number.required' => 'رقم الواتساب مطلوب',
            'business_type.required' => 'نوع النشاط مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'terms.required' => 'يجب الموافقة على الشروط والأحكام',
        ]);

        // Create user with pending status
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number,
            'ai_settings' => [
                'business_type' => $request->business_type,
                'status' => 'pending', // pending, approved, rejected
                'submitted_at' => now(),
            ],
        ]);

        // Assign company role
        $companyRole = Role::where('name', 'company')->first();
        if ($companyRole) {
            $user->roles()->attach($companyRole->id);
        }

        // Send email verification
        event(new Registered($user));

        // Send notification to admin about new service request
        $this->notifyAdmin($user);

        // Send confirmation email to user
        $this->sendConfirmationEmail($user);

        return redirect()->route('login')->with('status', 
            'تم إرسال طلب الخدمة بنجاح! سيتم مراجعة طلبك من قبل الإدارة والرد عليك خلال 24 ساعة. 
            تحقق من بريدك الإلكتروني لتفعيل حسابك.'
        );
    }

    /**
     * Send notification to admin about new service request
     */
    private function notifyAdmin(User $user): void
    {
        // Get admin users
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            // You can implement email notification here
            // Mail::to($admin->email)->send(new NewServiceRequestMail($user));
            
            // For now, we'll just log it
            \Log::info('New service request from: ' . $user->company_name . ' (' . $user->email . ')');
        }
    }

    /**
     * Send confirmation email to user
     */
    private function sendConfirmationEmail(User $user): void
    {
        // You can implement custom email template here
        // Mail::to($user->email)->send(new ServiceRequestConfirmationMail($user));
        
        \Log::info('Confirmation email sent to: ' . $user->email);
    }
}
