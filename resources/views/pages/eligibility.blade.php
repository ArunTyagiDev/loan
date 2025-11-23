@extends('layouts.app')

@section('title', 'Eligibility Check')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="fw-bold mb-4 text-center text-primary">Check Your Loan Eligibility</h2>
                    <p class="text-secondary text-center mb-4">
                        Share a few details to help us understand your financial profile. We will instantly calculate your
                        eligibility and create a personalised loan offer.
                    </p>

                    <form method="POST" action="{{ route('loan.eligibility.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                                class="form-control @error('full_name') is-invalid @enderror" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email (optional)</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone (optional)</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label fw-semibold">Monthly Salary (₹)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary') }}" min="0"
                                step="0.01" class="form-control @error('salary') is-invalid @enderror" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employment_type" class="form-label fw-semibold">Employment Type</label>
                                <select name="employment_type" id="employment_type"
                                    class="form-select @error('employment_type') is-invalid @enderror" required>
                                    <option value="">Select employment type</option>
                                    @foreach (['Salaried', 'Self-employed', 'Government', 'Freelancer', 'Consultant'] as $type)
                                        <option value="{{ $type }}" @selected(old('employment_type') === $type)>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('employment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="monthly_expenses" class="form-label fw-semibold">Monthly Expenses (₹)</label>
                                <input type="number" name="monthly_expenses" id="monthly_expenses"
                                    value="{{ old('monthly_expenses') }}" min="0" step="0.01"
                                    class="form-control @error('monthly_expenses') is-invalid @enderror" required>
                                @error('monthly_expenses')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Calculate Eligibility</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

