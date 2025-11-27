@extends('layouts.app')

@section('title', 'Eligibility Check')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
			<div class="card border-0 shadow-sm">
				<div class="card-body p-4 p-lg-5 position-relative">
                    <h2 class="fw-bold mb-4 text-center text-primary">Check Your Loan Eligibility</h2>
                    <p class="text-secondary text-center mb-4">
                        Share a few details to help us understand your financial profile. We will instantly calculate your
                        eligibility and create a personalised loan offer.
                    </p>

					<form id="eligibility-form" method="POST" action="{{ route('loan.eligibility.submit') }}">
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

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="pan" class="form-label fw-semibold">PAN Card (optional)</label>
								<input type="text" name="pan" id="pan" value="{{ old('pan') }}"
									pattern="[A-Z]{5}[0-9]{4}[A-Z]" maxlength="10" placeholder="ABCDE1234F"
									class="form-control @error('pan') is-invalid @enderror" style="text-transform: uppercase;">
								@error('pan')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<div class="form-text">Format: 5 letters, 4 digits, 1 letter (e.g., ABCDE1234F)</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="dob" class="form-label fw-semibold">Date of Birth (optional)</label>
								<input type="date" name="dob" id="dob" value="{{ old('dob') }}"
									class="form-control @error('dob') is-invalid @enderror">
								@error('dob')
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
							<button id="calculate-btn" type="submit" class="btn btn-primary btn-lg">Calculate Eligibility</button>
                        </div>
                    </form>
					{{-- Loader overlay --}}
					<div id="eligibility-loader" class="position-absolute top-0 start-0 w-100 h-100 d-none"
						style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(2px);">
						<div class="h-100 d-flex flex-column align-items-center justify-content-center">
							<div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
							<div class="fw-semibold text-primary">Calculating your eligibility...</div>
							<div class="text-secondary small">Please wait while we prepare your personalised offer.</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
	(function () {
		const form = document.getElementById('eligibility-form');
		const loader = document.getElementById('eligibility-loader');
		const btn = document.getElementById('calculate-btn');

		if (form && loader && btn) {
			form.addEventListener('submit', function () {
				loader.classList.remove('d-none');
				btn.disabled = true;
				btn.textContent = 'Calculating...';
			});
		}

		// Force uppercase PAN as user types
		const panInput = document.getElementById('pan');
		if (panInput) {
			panInput.addEventListener('input', function () {
				this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
			});
		}
	})();
</script>
@endpush

