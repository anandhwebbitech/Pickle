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
            <h3 class="legal-block-title">Introduction</h3>
            <p class="legal-text-body">
                We respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Information We Collect</h3>
            <p >
                Personal details (name, email, phone number, address) when you place an order.
            </p>
            <p>
                Payment information (secured through third-party gateways).
            </p>
            <p>
                Browsing data (collected via cookies for better user experience).
            </p>

            <!-- <p class="legal-text-body">
                All payments must be made at the time of purchase through our secure payment gateway. We do not store your credit card or bank details on our servers.
            </p> -->
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">How We Use Your Information</h3>
          <p>
              To process and fulfill orders.
          </p>
          <p>
              To communicate about order updates and promotions.
          </p>
          <p>
              To enhance website functionality and customer experience.
          </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Sharing of Information</h3>
            <p class="legal-text-body">
                We do not sell or trade your personal information. Your data may only be shared with delivery partners, payment processors, or legal authorities when required to fulfill services or comply with the law.
            </p>
        </div>
        <div class="legal-content-block">
            <h3 class="legal-block-title">Data Security</h3>
            <p class="legal-text-body">
                We implement security measures to protect your data from unauthorized access. However, no online transaction is 100% secure.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Cookies</h3>
            <p class="legal-text-body">
                Our website uses cookies to track visitor preferences. You can disable cookies in your browser settings.
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Your Rights</h3>
            <p class="legal-text-body">
                You can request access, correction, or deletion of your data by contacting us at info@anniskitchen.com .
            </p>
        </div>

        <div class="legal-content-block">
            <h3 class="legal-block-title">Policy Updates</h3>
            <p class="legal-text-body">
                We may update this policy, and changes will be posted on this page.
            </p>
        </div>

        <div class="legal-notice-panel">
            <h4 class="fw-bold mb-3" style="color: #212529;">Need further assistance?</h4>
            <p class="mb-0">
                If you have questions about this Privacy Policy or how your data is handled, please reach out to us at
                <strong style="color: #d63342;">info@anniskitchen.com</strong> or call us at
                <strong style="color: #d63342;">+91 9677739608</strong>.
            </p>
        </div>

    </main>


@endsection
