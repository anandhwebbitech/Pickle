@extends('frontend.layouts.app')
@section('content')


    <header class="legal-header-banner">
        <div class="container">
            <span class="update-date-label">Last Updated: January 2026</span>
            <h1 class="legal-main-title">Terms & <span style="color: #d63342;">Conditions</span></h1>
            <p class="text-muted fs-5">Everything you need to know about our service and your rights.</p>
        </div>
    </header>

    <main class="legal-document-container">

        <div class="legal-content-block">
            <h3 class="legal-block-title">Acceptance of Terms</h3>
            <p class="legal-text-body">
                By visiting our site and purchasing something from us, you engage in our "Service" and agree to be bound by the following terms and conditions. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and contributors of content.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Orders & Payments</h3>
            <p class="legal-text-body">
                When you place an order, you are making an offer to purchase the product. We reserve the right to cancel any order for any reason, including errors in pricing or stock availability.
            </p>
            <p class="legal-text-body">
                All payments must be made at the time of purchase through our secure payment gateway. We do not store your credit card or bank details on our servers.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Shipping & Delivery</h3>
            <p class="legal-text-body">
                We aim to process and dispatch all orders within 48 hours. Shipping costs are calculated at checkout based on your delivery address. While we strive for timely delivery, we are not responsible for delays caused by external logistics partners.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Returns & Refunds</h3>
            <p class="legal-text-body">
                As our pickles are food items, we cannot accept returns once a seal is broken. If you receive a damaged jar, please send us a video of the unboxing to our WhatsApp or Email within 24 hours of delivery. Verified claims will be eligible for a replacement or a full refund.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Intellectual Property</h3>
            <p class="legal-text-body">
                All content on this website, including images, logos, and recipes description, is the property of Yummy Pickle. You may not reproduce, duplicate, or copy any part of our brand identity without written permission from our management.
            </p>
        </div>

        <div class="legal-notice-panel">
            <h4 class="fw-bold mb-3" style="color: #212529;">Need further assistance?</h4>
            <p class="mb-0">
                If you have questions about these Terms, please reach out to our legal department at
                <a href="#"><strong style="color: #d63342;">legal@yummypickle.in</strong></a> or call us at
                <a href="tel:+919876543210"><strong style="color: #d63342;">+91 98765 43210</strong></a>.
            </p>
        </div>

    </main>
@endsection
