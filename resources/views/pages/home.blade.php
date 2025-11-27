@extends('layouts.app')

@section('title', 'Trusted Loan Solutions')

@section('content')
    <section class="hero rounded-4 p-5 shadow-sm mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Flexible loans tailored to your goals.</h1>
                <p class="lead text-secondary mb-4">
                    Check your eligibility in minutes, review a personalised offer, and move forward with
                    transparent terms. Our dedicated team ensures a quick and trustworthy experience.
                </p>
                <a href="{{ route('loan.eligibility') }}" class="btn btn-primary btn-lg me-3">Start Eligibility Check</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">Contact Us</a>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=720&q=80"
                    class="img-fluid rounded-4 shadow" alt="Loan planning illustration">
            </div>
        </div>
    </section>

    <section class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Simple Eligibility</h5>
                    <p class="card-text text-secondary">
                        Provide your income and expense details to instantly view your eligibility and the maximum amount
                        you can borrow.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Transparent Offers</h5>
                    <p class="card-text text-secondary">
                        Review interest rate, tenure, and key terms in a clean summary before proceeding to loan processing.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Secure Payments</h5>
                    <p class="card-text text-secondary">
                        Pay the processing fee using your preferred UPI wallet. Upload proof and track the status inside
                        your dashboard.
                    </p>
                </div>
            </div>
        </div>
    </section>

	<section class="bg-white rounded-4 shadow-sm p-4 mb-5">
		<h2 class="fw-bold mb-4">Why customers choose Capita Loan 24</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3 text-primary fs-3">✓</div>
                    <div>
                        <h5 class="fw-semibold mb-1">Fast decisions</h5>
                        <p class="text-secondary mb-0">Receive your preliminary approval in minutes and final approval
                            within 48 hours after verification.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3 text-primary fs-3">✓</div>
                    <div>
                        <h5 class="fw-semibold mb-1">Dedicated support</h5>
                        <p class="text-secondary mb-0">Our relationship managers are available on phone, WhatsApp, or
                            email for any assistance you need.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="rounded-4 shadow-sm p-4 mb-5" style="background: linear-gradient(180deg, #ffffff, #f3f6ff);">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<h2 class="fw-bold mb-3">About capitalloan24</h2>
				<p class="text-secondary mb-3">
					At Capita Loan 24, we’re on a mission to make borrowing simple, transparent, and fast.
					Whether you’re consolidating debt, funding education, or planning a milestone, we tailor loans
					to your needs with clear terms and reliable support.
				</p>
				<ul class="text-secondary mb-4">
					<li>Personalised offers based on your profile</li>
					<li>No hidden charges and transparent processing</li>
					<li>Support on call, email, and WhatsApp</li>
				</ul>
				<a href="{{ route('loan.eligibility') }}" class="btn btn-primary btn-lg">Check Eligibility</a>
			</div>
			<div class="col-lg-6 mt-4 mt-lg-0">
				<img class="img-fluid rounded-4 shadow-sm" alt="About capitalloan24"
					src="https://images.unsplash.com/photo-1553729784-e91953dec042?q=80&w=1280&auto=format&fit=crop">
			</div>
		</div>
	</section>

	<section class="bg-white rounded-4 shadow-sm p-4">
		<h2 class="fw-bold mb-4 text-center">What our customers say</h2>
		<div class="row g-4">
			<div class="col-md-4">
				<div class="h-100 border-0 card shadow-sm">
					<div class="card-body">
						<p class="mb-3">“The process was quick and transparent. I knew my eligibility instantly and the
							funds were disbursed right after verification.”</p>
						<div class="d-flex align-items-center">
							<div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">A</div>
							<div>
								<div class="fw-semibold">Anita S.</div>
								<div class="small text-secondary">Mumbai</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="h-100 border-0 card shadow-sm">
					<div class="card-body">
						<p class="mb-3">“capitalloan24 offered me the best rate for my salary bracket. The team was very
							responsive on WhatsApp.”</p>
						<div class="d-flex align-items-center">
							<div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">R</div>
							<div>
								<div class="fw-semibold">Rahul K.</div>
								<div class="small text-secondary">Bengaluru</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="h-100 border-0 card shadow-sm">
					<div class="card-body">
						<p class="mb-3">“Clear terms, no hidden fees, and super quick service. Highly recommended!”</p>
						<div class="d-flex align-items-center">
							<div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">M</div>
							<div>
								<div class="fw-semibold">Meera P.</div>
								<div class="small text-secondary">Delhi</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

