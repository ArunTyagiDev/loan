<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Http\Request;

class LoanManagementController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_applications' => LoanApplication::count(),
            'eligible_applications' => LoanApplication::where('is_eligible', true)->count(),
            'pending_payments' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'approved_loans' => LoanApplication::where('status', LoanApplication::STATUS_APPROVED)->count(),
        ];

        $recentApplications = LoanApplication::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
        ]);
    }

    public function index(Request $request)
    {
        $applications = LoanApplication::with(['user', 'payments' => function ($query) {
            $query->latest();
        }])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.loan-applications.index', [
            'applications' => $applications,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function show(LoanApplication $loanApplication)
    {
        $loanApplication->load(['user', 'payments']);

        return view('admin.loan-applications.show', [
            'application' => $loanApplication,
        ]);
    }

    public function updateStatus(Request $request, LoanApplication $loanApplication)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    LoanApplication::STATUS_PENDING,
                    LoanApplication::STATUS_VERIFIED,
                    LoanApplication::STATUS_APPROVED,
                    LoanApplication::STATUS_REJECTED,
                ]),
            ],
        ]);

        $loanApplication->update($validated);

        return redirect()
            ->back()
            ->with('status', 'Loan application status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Payment::STATUS_PENDING,
                    Payment::STATUS_RECEIVED,
                    Payment::STATUS_VERIFIED,
                    Payment::STATUS_REJECTED,
                ]),
            ],
        ]);

        $payment->update($validated);

        return redirect()
            ->back()
            ->with('status', 'Payment status updated successfully.');
    }
}
