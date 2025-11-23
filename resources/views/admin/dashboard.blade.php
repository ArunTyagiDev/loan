@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('header', 'Overview')

@section('content')
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-secondary small mb-1">Total Applications</p>
                        <h4 class="fw-bold mb-0">{{ $stats['total_applications'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-secondary small mb-1">Eligible</p>
                        <h4 class="fw-bold mb-0">{{ $stats['eligible_applications'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-secondary small mb-1">Pending Payments</p>
                        <h4 class="fw-bold mb-0">{{ $stats['pending_payments'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-secondary small mb-1">Approved Loans</p>
                        <h4 class="fw-bold mb-0">{{ $stats['approved_loans'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Recent Applications</h5>
                    <a href="{{ route('admin.loan-applications.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Applicant</th>
                                <th scope="col">Eligible Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentApplications as $application)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $application->user->full_name }}</div>
                                        <div class="text-secondary small">{{ $application->user->email ?? '—' }}</div>
                                    </td>
                                    <td>
                                        ₹ {{ number_format($application->eligible_amount, 2) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $application->status }}</span>
                                    </td>
                                    <td>{{ $application->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.loan-applications.show', $application) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">
                                        No applications yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

