@extends('layouts.app')

@section('title', 'Your Loan Offer')

@push('styles')
    <style>
        .adjust-card {
            background: radial-gradient(circle at top right, rgba(13, 110, 253, 0.12), rgba(255, 255, 255, 0.9));
            border: none;
        }
        .slider-wrapper {
            position: relative;
            padding: 1.5rem 1rem 0.5rem;
        }
        .slider-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #0d6efd;
            letter-spacing: 0.05rem;
        }
        .modern-range {
            -webkit-appearance: none;
            width: 100%;
            height: 12px;
            background: linear-gradient(90deg, #0d6efd, #2b54c9);
            border-radius: 999px;
            outline: none;
            transition: background 0.3s ease;
        }
        .modern-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 32px;
            height: 32px;
            background: #fff;
            border: 3px solid #0d6efd;
            border-radius: 50%;
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.35);
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
        }
        .modern-range::-webkit-slider-thumb:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.45);
        }
        .modern-range::-webkit-slider-thumb:active {
            cursor: grabbing;
        }
        .modern-range::-webkit-slider-thumb::after {
            content: '\f7a2';
            font-family: "Font Awesome 5 Free";
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            color: #0d6efd;
            font-weight: 900;
            font-size: 0.95rem;
        }
        .modern-range::-moz-range-thumb {
            width: 32px;
            height: 32px;
            background: #fff;
            border: 3px solid #0d6efd;
            border-radius: 50%;
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.35);
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
        }
        .modern-range::-moz-range-thumb:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.45);
        }
        .modern-range::-moz-range-thumb:active {
            cursor: grabbing;
        }
        .modern-range::-moz-range-thumb::after {
            content: '\f7a2';
            font-family: "Font Awesome 5 Free";
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            color: #0d6efd;
            font-weight: 900;
            font-size: 0.95rem;
        }
        .range-value-bubble {
            position: absolute;
            top: -38px;
            transform: translateX(-50%);
            background: #0d6efd;
            color: #fff;
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(13, 110, 253, 0.2);
            transition: left 0.1s ease;
            pointer-events: none;
        }
        .emi-badge {
            background: rgba(13, 110, 253, 0.08);
            border: 1px solid rgba(13, 110, 253, 0.15);
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }
        .selection-pill {
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.12);
            color: #0d3d8f;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .selection-pill svg {
            width: 20px;
            height: 20px;
        }
        @media (max-width: 767px) {
            .range-value-bubble {
                top: -32px;
            }
        }
    </style>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dIcpP7Yg4Yab9UXqFbnwH2OMp0GJrYqFG9Gap6x4vUJ06kTQcu5wMmJzZYkXYkpLj6hHn+VHOhfW8o7LJfLQ2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="mb-4">
                <h2 class="fw-bold text-primary">Personalised Loan Offer</h2>
                <p class="text-secondary mb-0">Review your tailored loan proposal based on the information provided.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Applicant Summary</h5>
                            <ul class="list-unstyled text-secondary">
                                <li class="mb-2"><strong>Name:</strong> {{ $application->user->full_name }}</li>
                                @if ($application->user->email)
                                    <li class="mb-2"><strong>Email:</strong> {{ $application->user->email }}</li>
                                @endif
                                @if ($application->user->phone)
                                    <li class="mb-2"><strong>Phone:</strong> {{ $application->user->phone }}</li>
                                @endif
                                <li class="mb-2"><strong>Monthly Salary:</strong> ₹ {{ number_format($application->salary, 2) }}</li>
                                <li class="mb-2"><strong>Monthly Expenses:</strong> ₹ {{ number_format($application->monthly_expenses, 2) }}</li>
                                <li class="mb-2"><strong>Employment Type:</strong> {{ $application->employment_type }}</li>
                                <li class="mb-2"><strong>Checked On:</strong>
                                    {{ optional($application->eligibility_checked_at)->format('d M Y, h:i A') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Offer Overview</h5>

                            @if ($application->is_eligible)
                                <p class="mb-2 text-uppercase small text-light">Eligible Loan Amount</p>
                                <h3 class="fw-bold">₹ {{ number_format($application->eligible_amount, 2) }}</h3>
                                <hr class="border border-light border-1 opacity-50">
                                <p class="mb-2"><strong>Interest Rate:</strong> {{ $application->interest_rate }}% p.a.</p>
                                <p class="mb-2"><strong>Max Tenure:</strong> {{ $application->tenure_months }} months</p>
                                <p class="mb-2"><strong>Your Preferred Amount:</strong> ₹ {{ number_format($requestedAmount, 2) }}</p>
                                <p class="mb-2"><strong>Your Preferred Tenure:</strong> {{ $requestedTenure }} months</p>
                                @if (!is_null($emi))
                                    <p class="mb-0"><strong>Estimated EMI:</strong> ₹ {{ number_format($emi, 2) }} / month</p>
                                @endif
                                <p class="mb-2"><strong>Processing Fee:</strong>
                                    ₹ {{ number_format($application->processing_fee, 2) }}</p>
                                <p class="mt-2 mb-0"><strong>Status:</strong> {{ $application->status }}</p>
                            @else
                                <h4 class="fw-bold">Currently Not Eligible</h4>
                                <p class="text-light">
                                    Based on the details provided, we are unable to extend a loan offer at this moment.
                                    Please review your expenses or reach out to our support team for guidance.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($application->is_eligible)
                <div class="card adjust-card shadow-sm mt-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                            <div>
                                <h5 class="fw-bold mb-1 text-primary">Tune Your Loan</h5>
                                <p class="text-secondary mb-0">Drag the sliders to adjust loan amount and tenure. We update your monthly EMI instantly.</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="selection-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m12 0a8 8 0 11-16 0 8 8 0 0116 0z" />
                                    </svg>
                                    <span id="summaryAmount">₹ {{ number_format($requestedAmount, 2) }}</span>
                                </span>
                                <span class="selection-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4m5 4.2V8.4c0-2.24-1.776-4.2-3.963-4.4a48.43 48.43 0 00-15.074 0C5.776 4.2 4 6.16 4 8.4v7.8c0 2.24 1.776 4.2 3.963 4.4 4.994.526 10.08.526 15.074 0C21.224 20.2 23 18.24 23 16z" />
                                    </svg>
                                    <span id="summaryTenure">{{ $requestedTenure }} months</span>
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('loan.offer', $application) }}" method="GET" class="row g-4 align-items-end" id="loanAdjustForm" data-interest="{{ $application->interest_rate }}">
                            <div class="col-lg-7">
                                <div class="slider-wrapper">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="slider-label">Loan Amount</span>
                                        <span class="text-muted small">Max ₹ {{ number_format($maxAmount, 2) }}</span>
                                    </div>
                                    <input
                                        type="range"
                                        class="modern-range"
                                        id="amountRange"
                                        name="amount"
                                        min="{{ $maxAmount > 0 ? min(10000, $maxAmount) : 0 }}"
                                        max="{{ $maxAmount }}"
                                        step="1000"
                                        value="{{ $requestedAmount }}"
                                    >
                                    <span class="range-value-bubble" id="amountBubble">₹ {{ number_format($requestedAmount, 0) }}</span>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="slider-wrapper">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="slider-label">Tenure (Months)</span>
                                        <span class="text-muted small">Max {{ $maxTenure }}</span>
                                    </div>
                                    <input
                                        type="range"
                                        class="modern-range"
                                        id="tenureRange"
                                        name="tenure"
                                        min="{{ min(6, $maxTenure) }}"
                                        max="{{ $maxTenure }}"
                                        step="1"
                                        value="{{ $requestedTenure }}"
                                    >
                                    <span class="range-value-bubble" id="tenureBubble">{{ $requestedTenure }} months</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                    <div class="emi-badge flex-grow-1" id="emiPreview">
                                        @if (!is_null($emi))
                                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                                <div>
                                                    <strong>Estimated EMI:</strong> ₹ <span id="emiAmount">{{ number_format($emi, 2) }}</span> / month
                                                </div>
                                                <div class="text-secondary small">
                                                    Based on <span id="emiTenure">{{ $requestedTenure }}</span> months at {{ $application->interest_rate }}% p.a.
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-secondary">Adjust amount or tenure to view the EMI.</div>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Update Offer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Your Selection</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded-4 px-4 py-3">
                                <p class="text-secondary text-uppercase small mb-1">Loan Amount</p>
                                <h4 class="fw-bold text-primary mb-0" id="selectionAmount">₹ {{ number_format($requestedAmount, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-4 px-4 py-3">
                                <p class="text-secondary text-uppercase small mb-1">Tenure</p>
                                <h4 class="fw-bold text-primary mb-0" id="selectionTenure">{{ $requestedTenure }} months</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Terms &amp; Conditions</h5>
                    <p class="text-secondary">{{ $application->terms }}</p>
                </div>
            </div>

            @if ($application->is_eligible)
                <div class="text-end mt-4">
                    <a href="{{ route('loan.payment', $application) }}" class="btn btn-primary btn-lg">
                        Proceed to Processing Fee Payment
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('loanAdjustForm');
            if (!form) {
                return;
            }

            const interestRate = parseFloat(form.dataset.interest || 0);
            const amountRange = document.getElementById('amountRange');
            const tenureRange = document.getElementById('tenureRange');
            const amountBubble = document.getElementById('amountBubble');
            const tenureBubble = document.getElementById('tenureBubble');
            const emiAmount = document.getElementById('emiAmount');
            const emiTenure = document.getElementById('emiTenure');
            const emiPreview = document.getElementById('emiPreview');
            const summaryAmount = document.getElementById('summaryAmount');
            const summaryTenure = document.getElementById('summaryTenure');
            const selectionAmount = document.getElementById('selectionAmount');
            const selectionTenure = document.getElementById('selectionTenure');

            const formatCurrency = (value) => {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    maximumFractionDigits: 0
                }).format(value);
            };

            const updateBubblePosition = (range, bubble) => {
                const min = parseFloat(range.min) || 0;
                const max = parseFloat(range.max) || 0;
                const value = parseFloat(range.value) || 0;
                const percent = max === min ? 0 : ((value - min) * 100) / (max - min);
                bubble.style.left = `calc(${percent}% + (${8 - percent * 0.15}px))`;
            };

            const updateDisplays = () => {
                const amount = parseFloat(amountRange.value) || 0;
                const tenure = parseInt(tenureRange.value) || 0;

                amountBubble.textContent = formatCurrency(amount).replace('₹', '₹ ');
                tenureBubble.textContent = `${tenure} months`;
                summaryAmount.textContent = formatCurrency(amount);
                summaryTenure.textContent = `${tenure} months`;
                selectionAmount.textContent = formatCurrency(amount);
                selectionTenure.textContent = `${tenure} months`;

                updateBubblePosition(amountRange, amountBubble);
                updateBubblePosition(tenureRange, tenureBubble);

                if (interestRate > 0 && amount > 0 && tenure > 0) {
                    const monthlyRate = (interestRate / 12) / 100;
                    let emi;
                    if (monthlyRate > 0) {
                        const numerator = amount * monthlyRate * Math.pow(1 + monthlyRate, tenure);
                        const denominator = Math.pow(1 + monthlyRate, tenure) - 1;
                        emi = numerator / denominator;
                    } else {
                        emi = amount / tenure;
                    }
                    const emiValue = Math.round(emi * 100) / 100;

                    if (emiAmount && emiTenure) {
                        emiAmount.textContent = emiValue.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        emiTenure.textContent = tenure;
                    } else if (emiPreview) {
                        emiPreview.innerHTML = `
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                <div>
                                    <strong>Estimated EMI:</strong> ₹ ${emiValue.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} / month
                                </div>
                                <div class="text-secondary small">
                                    Based on ${tenure} months at ${interestRate}% p.a.
                                </div>
                            </div>
                        `;
                    }
                }
            };

            updateDisplays();

            amountRange.addEventListener('input', updateDisplays);
            tenureRange.addEventListener('input', updateDisplays);
        });
    </script>
@endpush

