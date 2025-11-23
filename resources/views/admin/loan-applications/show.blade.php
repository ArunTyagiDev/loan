@extends('admin.layouts.app')

@section('title', 'Application Details')

@section('header', 'Application Details')

@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Applicant</h5>
                        <p class="mb-1"><strong>{{ $application->user->full_name }}</strong></p>
                        <p class="mb-1 text-secondary">{{ $application->user->email ?? '—' }}</p>
                        <p class="mb-0 text-secondary">{{ $application->user->phone ?? '—' }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Financials</h5>
                        <p class="mb-2">Monthly Salary: <strong>₹ {{ number_format($application->salary, 2) }}</strong></p>
                        <p class="mb-2">Monthly Expenses: <strong>₹ {{ number_format($application->monthly_expenses, 2) }}</strong></p>
                        <p class="mb-2">Employment Type: <strong>{{ $application->employment_type }}</strong></p>
                        <p class="mb-2">Eligible Amount: <strong>₹ {{ number_format($application->eligible_amount, 2) }}</strong></p>
                        <p class="mb-2">Interest Rate: <strong>{{ $application->interest_rate }}% p.a.</strong></p>
                        <p class="mb-0">Tenure: <strong>{{ $application->tenure_months }} months</strong></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Status</h5>
                            <span class="badge bg-primary fs-6">{{ $application->status }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.loan-applications.update', $application) }}" class="row g-3">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Update Status</label>
                                <select name="status" class="form-select">
                                    @foreach ([
        App\Models\LoanApplication::STATUS_PENDING,
        App\Models\LoanApplication::STATUS_VERIFIED,
        App\Models\LoanApplication::STATUS_APPROVED,
        App\Models\LoanApplication::STATUS_REJECTED,
    ] as $status)
                                        <option value="{{ $status }}" @selected($application->status === $status)>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Processing Fee Payments</h5>
                        @if ($application->payments->isEmpty())
                            <p class="text-secondary mb-0">No payments submitted yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">Paid On</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Evidence</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($application->payments as $payment)
                                            <tr>
                                                <td>{{ optional($payment->paid_at)->format('d M Y, h:i A') }}</td>
                                                <td>₹ {{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ $payment->transaction_id }}</td>
                                                <td><span class="badge bg-secondary">{{ $payment->status }}</span></td>
                                                <td>
                                                    @if ($payment->confirmation_path)
                                                        <a href="{{ asset('storage/' . $payment->confirmation_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            View File
                                                        </a>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="d-flex gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" class="form-select form-select-sm">
                                                            @foreach ([
        App\Models\Payment::STATUS_PENDING,
        App\Models\Payment::STATUS_RECEIVED,
        App\Models\Payment::STATUS_VERIFIED,
        App\Models\Payment::STATUS_REJECTED,
    ] as $status)
                                                                <option value="{{ $status }}" @selected($payment->status === $status)>
                                                                    {{ $status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Terms &amp; Notes</h5>
                        <p class="text-secondary">{{ $application->terms }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

