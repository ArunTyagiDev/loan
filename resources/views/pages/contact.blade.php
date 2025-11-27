@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4 text-primary">We are here to help</h2>
                    <p class="text-secondary mb-4">
                        Reach out to our dedicated support team for assistance with your loan application, documentation,
                        or repayment queries.
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100 bg-light">
                                <h5 class="fw-bold">Customer Support</h5>
                                <p class="mb-2 text-secondary">Phone: <strong>+91 9756862640</strong></p>
                                <p class="mb-2 text-secondary">Email: <strong>support@loansolutions.in</strong></p>
                                <p class="mb-0 text-secondary">Hours: Monday to Saturday, 9:00 AM – 7:00 PM</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100 bg-light">
                                <h5 class="fw-bold">Branch Office</h5>
                                <p class="mb-2 text-secondary">Loan Solutions Pvt. Ltd.</p>
                                <p class="mb-2 text-secondary">18, Business Park, Bandra Kurla Complex</p>
                                <p class="mb-0 text-secondary">Mumbai, Maharashtra 400051</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold">Send us a message</h5>
                        <p class="text-secondary mb-3">Share your question and we will call you back within 24 hours.</p>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Full name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="4" placeholder="Your message"></textarea>
                                </div>
                            </div>
                            <div class="d-grid d-md-flex justify-content-md-end mt-3">
                                <button class="btn btn-primary" type="button" disabled>Coming Soon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

