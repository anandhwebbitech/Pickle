@extends('frontend.layouts.app')
@section('content')



    <header class="legal-header-banner">
        <div class="container">
            <span class="update-date-label">Last Updated: January 2026</span>
            <h1 class="legal-main-title">Shipping <span style="color: #d63342;">Policy</span></h1>
            <p class="text-muted fs-5">
                Everything you need to know about order processing, shipping, and delivery timelines.
            </p>
        </div>
    </header>

    <main class="legal-document-container">

        {{-- <div class="legal-content-block">
            <h3 class="legal-block-title">Order Processing</h3>
            <p class="legal-text-body">
                All orders placed on Yummy Pickle are processed within 24–48 working hours after successful payment confirmation, excluding Sundays and public holidays.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Shipping Coverage</h3>
            <p class="legal-text-body">
                We currently ship across India. Delivery availability may vary depending on your location and courier serviceability.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Shipping Charges</h3>
            <p class="legal-text-body">
                Shipping charges are calculated automatically at checkout based on your delivery address and order weight. Any applicable charges will be clearly displayed before payment.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Estimated Delivery Time</h3>
            <p class="legal-text-body">
                Estimated delivery timelines range between 3–7 business days after dispatch, depending on your location. Remote areas may require additional delivery time.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Shipping Delays</h3>
            <p class="legal-text-body">
                While we strive to ensure timely delivery, Yummy Pickle is not responsible for delays caused by courier partners, weather conditions, natural calamities, or unforeseen circumstances.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Damaged or Missing Packages</h3>
            <p class="legal-text-body">
                If you receive a damaged package, please record an unboxing video and contact us within 24 hours of delivery. Verified claims will be eligible for a replacement or refund as per our policy.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Incorrect Address</h3>
            <p class="legal-text-body">
                Please ensure your shipping address is accurate at checkout. We are not responsible for non-delivery due to incorrect or incomplete address details provided by the customer.
            </p>
        </div> --}}
        <div class="legal-content-block">
            <p class="legal-text-body">
                We offer shipping across India. All orders are processed and dispatched within 2–3 business days after order confirmation.            
            </p>
            <p class="legal-text-body">
                Delivery timelines depend on the destination and usually range between 5–7 business days.
            </p>
            <p class="legal-text-body">
                Delivery timelines depend on the destination and usually range between 5–7 business days.
            </p>
            <p class="legal-text-body">
                Please note that delays caused by courier partners, weather conditions, or unforeseen circumstances are beyond our control.
            </p>
        </div>

        <div class="legal-notice-panel">
            <h4 class="fw-bold mb-3" style="color: #212529;">Need further assistance?</h4>
            <p class="mb-0">
                If you have questions about our Shipping Policy, please contact us at
                <strong style="color: #d63342;">info@anniskitchen.com</strong> or call
                <strong style="color: #d63342;">+91 9677739608</strong>.
            </p>
        </div>

    </main>


@endsection
