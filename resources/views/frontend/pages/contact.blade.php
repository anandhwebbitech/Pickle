@extends('frontend.layouts.app')
@section('content')

    <section class="py-5" style="background-color: #fcf9f4;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-2">
                            <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted text-decoration-none small">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none small">Shop</a></li> -->
                            <li class="breadcrumb-item active small text-calor fw-bold" aria-current="page">Contact</li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold text-dark mb-0">Our <span style="color: #5E0E3C;">Contact</span></h1>
                    <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #5E0E3C; border-radius: 2px;"></div>

                </div>
            </div>
        </div>
    </section>


    <section class="container py-5 mt-5">
        <div class="row g-5">

            <div class="col-lg-5">
                <div class="contact-details-card">
                    <h2 class="fw-bold mb-5" style="color: #212529;">Contact Details</h2>

                    <div class="contact-info-block">
                        <div class="brand-icon-square"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <h6 class="info-label">Call or WhatsApp</h6>
                            <a href="tel:+919876543210"><p class="info-content">+91 98765 43210</p></a>
                            <a href="tel:+914222456789"><p class="info-content">+91 422 245 6789</p></a>
                        </div>
                    </div>

                    <div class="contact-info-block">
                        <div class="brand-icon-square"><i class="bi bi-envelope-open-fill"></i></div>
                        <div>
                            <h6 class="info-label">Email Address</h6>
                            <a href="mailto:support@yummypickle.in"><p class="info-content">support@yummypickle.in</p></a>
                            <a href="mailto:sales@yummypickle.in"><p class="info-content">sales@yummypickle.in</p></a>
                        </div>
                    </div>

                    <div class="contact-info-block">
                        <div class="brand-icon-square"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <h6 class="info-label">Our Main Office</h6>
                            <p class="info-content">No 45, Heritage Street, Gandhipuram,<br>Coimbatore, Tamil Nadu 641012</p>
                        </div>
                    </div>

                    <div class="pt-4 border-top mt-4">
                        <p class="fw-bold small text-uppercase mb-3" style="color: #d63342; letter-spacing: 1px;">Join Our Community</p>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-dark rounded-circle px-2 py-1"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="btn btn-dark rounded-circle px-2 py-1"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-dark rounded-circle px-2 py-1"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 ps-lg-5">
                <div class="py-2">
                    <h2 class="fw-bold mb-5" style="color: #212529;">Send Us a Message</h2>
                    <form id="contactForm" method="POST" >
                         @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="field-label-text">Full Name</label>
                                <input type="text" class="form-control contact-field-input " name="fullname" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label-text">Phone Number</label>
                                <input type="tel" class="form-control contact-field-input" name="phone_number" placeholder="e.g. +91 98765 43210" required>
                            </div>
                            <div class="col-12">
                                <label class="field-label-text">Email Address</label>
                                <input type="email" class="form-control contact-field-input" name="email" placeholder="yourname@email.com" required>
                            </div>
                            <div class="col-12">
                                <label class="field-label-text">How can we help?</label>
                                <textarea class="form-control contact-field-input" rows="5" name="message" placeholder="Tell us more about your inquiry..." required></textarea>
                            </div>
                            <div class="col-12 pt-3">
                                <button type="submit" id="contactBtn" class="btn-submit-contact shadow">Submit Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="contact-map-container shadow-sm">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125322.44153114513!2d76.88483281989437!3d11.012014524021207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f973901%3A0x2627a85b73b366!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </section>
    @push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var button = $('#contactBtn');

        button.prop('disabled', true).text('Sending...');

        $.ajax({
            url: "{{ route('contact.send') }}",
            method: "POST",
            data: form.serialize(),
            success: function(response) {
                alert(response.success);
                form.trigger("reset");
                button.prop('disabled', false).text('Send Message');
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMsg = '';
                for (var key in errors) {
                    errorMsg += errors[key][0] + '\n';
                }
                alert(errorMsg);
                button.prop('disabled', false).text('Send Message');
            }
        });
    });
</script>
@endpush
@endsection
