@extends('layouts.app')

@section('title', 'Processing Fee Payment')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="mb-4">
                <h2 class="fw-bold text-primary">Processing Fee Payment</h2>
                <p class="text-secondary mb-0">
                    Please review the instructions below, scan the QR code using your preferred payment app, and upload the
                    transaction confirmation.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-3">Scan to Pay</h5>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=230x230&data=upi://pay?pa=loansolutions@upi&pn=Loan%20Solutions&cu=INR"
                                alt="UPI QR Code" class="img-fluid rounded-3 border mb-3">
                            <p class="text-secondary small mb-0">
                                Use UPI apps like Google Pay, PhonePe, or Paytm to scan the QR code. Ensure that the
                                transaction reference is captured in your screenshot or PDF before uploading.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Upload Payment Confirmation</h5>

                            <div class="alert alert-info">
                                <strong>Processing fee:</strong> ₹ {{ number_format($application->processing_fee, 2) }}
                            </div>

                            <form method="POST" action="{{ route('loan.payment.store', $application) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="amount" class="form-label fw-semibold">Amount Paid (₹)</label>
                                    <input type="number" step="0.01" min="0" name="amount" id="amount"
                                        value="{{ old('amount', $application->processing_fee) }}"
                                        class="form-control @error('amount') is-invalid @enderror" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="transaction_id" class="form-label fw-semibold">Transaction ID</label>
                                    <input type="text" name="transaction_id" id="transaction_id"
                                        value="{{ old('transaction_id') }}"
                                        class="form-control @error('transaction_id') is-invalid @enderror" required>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label fw-semibold">Payment Method</label>
                                    <select name="payment_method" id="payment_method"
                                        class="form-select @error('payment_method') is-invalid @enderror" required>
                                        <option value="">Choose...</option>
                                        @foreach (['Google Pay', 'PhonePe', 'Paytm', 'BHIM UPI', 'Other'] as $method)
                                            <option value="{{ $method }}" @selected(old('payment_method') === $method)>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="confirmation_file" class="form-label fw-semibold">Upload Screenshot / PDF</label>
                                    <input type="file" name="confirmation_file" id="confirmation_file"
                                        class="form-control @error('confirmation_file') is-invalid @enderror" required>
                                    <div class="form-text">Accepted formats: JPG, PNG, or PDF (max 4 MB).</div>
                                    @error('confirmation_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Payment Proof</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if ($application->payments->isNotEmpty())
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Payment History</h5>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Method</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($application->payments as $payment)
                                        <tr>
                                            <td>{{ optional($payment->paid_at)->format('d M Y, h:i A') }}</td>
                                            <td>₹ {{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->transaction_id }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $payment->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

