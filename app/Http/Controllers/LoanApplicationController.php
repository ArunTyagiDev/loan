<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoanApplicationController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function eligibilityForm()
    {
        return view('pages.eligibility');
    }

    public function submitEligibility(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
			'pan' => ['nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/'],
			'dob' => ['nullable', 'date'],
            'salary' => ['required', 'numeric', 'min:0'],
            'employment_type' => ['required', 'string', 'max:120'],
            'monthly_expenses' => ['required', 'numeric', 'min:0'],
        ]);

        $user = $this->findOrCreateUser($data);

        $eligibility = $this->calculateEligibility(
            $data['salary'],
            $data['monthly_expenses'],
            $data['employment_type']
        );

        $loanApplication = LoanApplication::create([
            'user_id' => $user->id,
            'salary' => $data['salary'],
            'employment_type' => $data['employment_type'],
            'monthly_expenses' => $data['monthly_expenses'],
            'is_eligible' => $eligibility['is_eligible'],
            'eligible_amount' => $eligibility['eligible_amount'],
            'interest_rate' => $eligibility['interest_rate'],
            'tenure_months' => $eligibility['tenure_months'],
            'terms' => $eligibility['terms'],
            'processing_fee' => $eligibility['processing_fee'],
            'status' => $eligibility['is_eligible']
                ? LoanApplication::STATUS_PENDING
                : LoanApplication::STATUS_REJECTED,
            'eligibility_checked_at' => now(),
        ]);

        return redirect()
            ->route('loan.offer', $loanApplication)
            ->with('status', $eligibility['is_eligible']
                ? 'Congratulations! You are eligible for a loan offer.'
                : 'We are sorry, you are currently not eligible for a loan.');
    }

    public function showOffer(Request $request, LoanApplication $loanApplication)
    {
        $loanApplication->load(['user', 'payments']);

        $maxAmount = (float) $loanApplication->eligible_amount;
        $maxTenure = (int) $loanApplication->tenure_months;

        $requestedAmount = (float) $request->query('amount', $maxAmount);
        $requestedTenure = (int) $request->query('tenure', $maxTenure);

        $minimumAmount = $maxAmount > 0 ? min(10000, $maxAmount) : 0;
        $requestedAmount = round(
            min(max($requestedAmount, $minimumAmount), $maxAmount),
            2
        );

        if ($maxTenure > 0) {
            $minimumTenure = min(6, $maxTenure);
            $requestedTenure = max(min($requestedTenure, $maxTenure), $minimumTenure);
        } else {
            $requestedTenure = 0;
        }

        $emi = null;
        $monthlyRate = null;

        if (
            $loanApplication->interest_rate &&
            $requestedAmount > 0 &&
            $requestedTenure > 0
        ) {
            $monthlyRate = ($loanApplication->interest_rate / 12) / 100;

            if ($monthlyRate > 0) {
                $emi = $requestedAmount *
                    $monthlyRate *
                    pow(1 + $monthlyRate, $requestedTenure) /
                    (pow(1 + $monthlyRate, $requestedTenure) - 1);
            } else {
                $emi = $requestedAmount / $requestedTenure;
            }

            $emi = round($emi, 2);
        }

        return view('pages.offer', [
            'application' => $loanApplication,
            'maxAmount' => $maxAmount,
            'maxTenure' => $maxTenure,
            'requestedAmount' => $requestedAmount,
            'requestedTenure' => $requestedTenure,
            'emi' => $emi,
            'monthlyRate' => $monthlyRate,
        ]);
    }

    public function showPaymentForm(LoanApplication $loanApplication)
    {
        abort_unless($loanApplication->is_eligible, 404);

        $loanApplication->load('payments');

        return view('pages.payment', [
            'application' => $loanApplication,
        ]);
    }

    public function storePayment(
        Request $request,
        LoanApplication $loanApplication
    ) {
        abort_unless($loanApplication->is_eligible, 404);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_id' => ['required', 'string', 'max:120'],
            'payment_method' => ['required', 'string', 'max:60'],
            'confirmation_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],
        ]);

        $path = $request->file('confirmation_file')->store('payments', 'public');

        $loanApplication->payments()->create([
            'amount' => $validated['amount'],
            'transaction_id' => $validated['transaction_id'],
            'payment_method' => $validated['payment_method'],
            'status' => Payment::STATUS_PENDING,
            'confirmation_path' => $path,
            'paid_at' => now(),
            'meta' => [
                'submitted_from' => $request->ip(),
                'user_agent' => Str::limit($request->userAgent(), 255),
            ],
        ]);

        $loanApplication->update([
            'status' => LoanApplication::STATUS_VERIFIED,
        ]);

        return redirect()
            ->route('loan.payment.success', $loanApplication)
            ->with('status', 'Payment confirmation uploaded successfully. Our team will verify and get back to you.');
    }

    public function paymentSuccess(LoanApplication $loanApplication)
    {
        $loanApplication->load(['user', 'payments']);

        return view('pages.payment-success', [
            'application' => $loanApplication,
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function downloadQr()
    {
        $local = public_path('assets/paytm-qr.png');
        if (file_exists($local)) {
            return response()->download($local, 'capitalloan24-paytm-qr.png', [
                'Content-Type' => 'image/png',
            ]);
        }

        $fallbackUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=230x230&data=upi://pay?pa=Paytmqr2810050501011meg3b1gpdl9@paytm&pn=Capita%20Loan%2024&cu=INR';

        try {
            $res = Http::timeout(10)->get($fallbackUrl);
            if ($res->successful()) {
                return response($res->body(), 200, [
                    'Content-Type' => $res->header('Content-Type', 'image/png'),
                    'Content-Disposition' => 'attachment; filename="capitalloan24-paytm-qr.png"',
                    'Cache-Control' => 'no-store',
                ]);
            }
        } catch (\Throwable $e) {
            // fallthrough to a simple 404 image
        }

        return response('QR unavailable', 503, ['Content-Type' => 'text/plain']);
    }

    protected function findOrCreateUser(array $data): User
    {
        $query = null;

        if (!empty($data['email'])) {
            $query = User::where('email', $data['email'])->first();
        }

        if (!$query && !empty($data['phone'])) {
            $query = User::where('phone', $data['phone'])->first();
        }

        if ($query) {
            $query->update([
                'full_name' => $data['full_name'],
                'email' => $data['email'] ?? $query->email,
                'phone' => $data['phone'] ?? $query->phone,
            ]);

            return $query;
        }

        return User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);
    }

    protected function calculateEligibility(
        float $salary,
        float $expenses,
        string $employmentType
    ): array {
        $disposableIncome = max($salary - $expenses, 0);

        if ($disposableIncome <= 0) {
            return [
                'is_eligible' => false,
                'eligible_amount' => 0,
                'interest_rate' => null,
                'tenure_months' => null,
                'terms' => 'Unfortunately, your current disposable income is insufficient to support a loan.',
                'processing_fee' => null,
            ];
        }

        $multipliers = [
            'salaried' => 18,
            'self_employed' => 16,
            'government' => 20,
            'default' => 15,
        ];

        $employmentKey = Str::slug($employmentType);
        $employmentKey = str_replace('-', '_', $employmentKey);

        $multiplier = $multipliers[$employmentKey] ?? $multipliers['default'];

        if ($salary >= 100000) {
            $interestRate = 10.5;
            $tenure = 60;
        } elseif ($salary >= 50000) {
            $interestRate = 11.75;
            $tenure = 48;
        } else {
            $interestRate = 13.25;
            $tenure = 36;
        }

        $eligibleAmount = round($salary * 2.5, 2);
        $eligibleAmount = max($eligibleAmount, 0);

        $processingFee = $eligibleAmount > 0
            ? round($eligibleAmount * 0.02, 2)
            : null;

        $terms = collect([
            'Flexible tenure with no prepayment penalties after 12 months.',
            'Interest rate subject to final verification of documents.',
            'Processing fee is non-refundable once the application is submitted.',
            'Loan disbursal within 48 hours of final approval.',
        ])->implode(' ');

        return [
            'is_eligible' => $eligibleAmount > 0,
            'eligible_amount' => $eligibleAmount,
            'interest_rate' => $interestRate,
            'tenure_months' => $tenure,
            'terms' => $terms,
            'processing_fee' => $processingFee,
        ];
    }
}
