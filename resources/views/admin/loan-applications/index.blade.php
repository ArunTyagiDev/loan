@extends('admin.layouts.app')

@section('title', 'Loan Applications')

@section('header', 'Loan Applications')

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-uppercase text-secondary">Applicant</label>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control"
                            placeholder="Name, email, or phone">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-uppercase text-secondary">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach ([
        App\Models\LoanApplication::STATUS_PENDING,
        App\Models\LoanApplication::STATUS_VERIFIED,
        App\Models\LoanApplication::STATUS_APPROVED,
        App\Models\LoanApplication::STATUS_REJECTED,
    ] as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit">Filter</button>
                        <a href="{{ route('admin.loan-applications.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Applicant</th>
                                <th scope="col">Salary / Expenses</th>
                                <th scope="col">Eligible Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payments</th>
                                <th scope="col">Created</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $application)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $application->user->full_name }}</div>
                                        <div class="text-secondary small">{{ $application->user->email ?? '—' }}</div>
                                    </td>
                                    <td>
                                        <div>Salary: ₹ {{ number_format($application->salary, 2) }}</div>
                                        <div class="text-secondary small">Expenses: ₹ {{ number_format($application->monthly_expenses, 2) }}</div>
                                    </td>
                                    <td>₹ {{ number_format($application->eligible_amount, 2) }}</td>
                                    <td><span class="badge bg-primary">{{ $application->status }}</span></td>
                                    <td>{{ $application->payments->count() }}</td>
                                    <td>{{ $application->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.loan-applications.show', $application) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-4">
                                        No applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    </div>
@endsection

