@extends('frontend.layouts.app')
@section('content')
   <header class="legal-header-banner">
        <div class="container">
            <span class="update-date-label">Last Updated: January 2026</span>
            <h1 class="legal-main-title">Privacy  <span style="color: #d63342;">Policy</span></h1>
            <p class="text-muted fs-5">Everything you need to know about how we collect, use, and protect your information.</p>
        </div>
    </header>

    <main class="legal-document-container">

        <div class="legal-content-block">
            <h3 class="legal-block-title">Information We Collect</h3>
            <p class="legal-text-body">
                When you visit our website or place an order, we may collect personal information such as your name, phone number, email address, delivery address, and order details. We may also collect basic technical data like IP address, browser type, and device information for analytics purposes.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">How We Use Your Information</h3>
            <p class="legal-text-body">
                When you place an order, you are making an offer to purchase the product. We reserve the right to cancel any order for any reason, including errors in pricing or stock availability.
            </p>
            <!-- <p class="legal-text-body">
                All payments must be made at the time of purchase through our secure payment gateway. We do not store your credit card or bank details on our servers.
            </p> -->
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Payments & Data Security</h3>
            <p class="legal-text-body">
                All payments are securely processed through trusted third-party payment gateways. We do not store your credit card, debit card, or banking information on our servers. Appropriate security measures are taken to protect your personal data.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Sharing of Information</h3>
            <p class="legal-text-body">
                We do not sell or trade your personal information. Your data may only be shared with delivery partners, payment processors, or legal authorities when required to fulfill services or comply with the law.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Cookies & Tracking</h3>
            <p class="legal-text-body">
                Our website uses cookies to enhance user experience and analyze website performance. You may disable cookies through your browser settings, though some features may not function properly.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Your Rights</h3>
            <p class="legal-text-body">
                You have the right to access, update, or request deletion of your personal information. You may also opt out of marketing communications at any time.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Policy Updates</h3>
            <p class="legal-text-body">
                We reserve the right to update this Privacy Policy at any time. Changes will be reflected on this page with a revised update date.
            </p>
        </div>

        <div class="legal-notice-panel">
            <h4 class="fw-bold mb-3" style="color: #212529;">Need further assistance?</h4>
            <p class="mb-0">
                If you have questions about this Privacy Policy or how your data is handled, please reach out to us at
                <strong style="color: #d63342;">legal@yummypickle.in</strong> or call us at
                <strong style="color: #d63342;">+91 98765 43210</strong>.
            </p>
        </div>

    </main>


@endsection
