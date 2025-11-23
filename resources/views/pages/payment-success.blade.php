@extends('layouts.app')

@section('title', 'Payment Submitted')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="display-4 text-success mb-3">✓</div>
                    <h2 class="fw-bold mb-3">Payment Confirmation Received</h2>
                    <p class="text-secondary mb-4">
                        Thank you for submitting your processing fee proof. Our verification team will review the payment
                        and share the next steps shortly.
                    </p>

                    <div class="row justify-content-center g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 bg-light">
                                <p class="text-uppercase text-secondary small mb-1">Loan Amount</p>
                                <h5 class="fw-bold">₹ {{ number_format($application->eligible_amount, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 bg-light">
                                <p class="text-uppercase text-secondary small mb-1">Interest Rate</p>
                                <h5 class="fw-bold">{{ $application->interest_rate }}% p.a.</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-3 bg-light">
                                <p class="text-uppercase text-secondary small mb-1">Tenure</p>
                                <h5 class="fw-bold">{{ $application->tenure_months }} months</h5>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

