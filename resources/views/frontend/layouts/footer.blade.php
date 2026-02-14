<footer class="mt-5 mx-3">
    <div class="footer-pill-container">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4">
                    <div class="mb-4">
                        <img src="asset/img/anni-logo.png" alt="Yummy Pickle" style="width: 100px;" class="mb-2">
                        <h5 class="fw-bold mb-0 text-ylo">Yummy Pickle</h5>
                    </div>
                    <p class="text-ylo small lh-lg">
                        At UV Food Products, we believe that quality is the foundation of trust. That’s why we are dedicated to producing and delivering the purest and most authentic cold-pressed oils.
                    </p>
                    <div class="d-flex gap-2 mt-4 mb-4">
                        <a href="#" class="footer-social-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social-circle"><i class="bi bi-google"></i></a>
                        <a href="#" class="footer-social-circle"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="footer-social-circle"><i class="bi bi-instagram"></i></a>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-4 text-uppercase text-ylo" style="letter-spacing: 1px;">Quick Links</h6>
                    <div class="d-flex flex-column">
                        <a href="{{route('about')}}" class="footer-link"><i class="bi bi-chevron-right small" style="color:white;"></i> About Us</a>
                        <a href="{{ route('contact') }}" class="footer-link"><i class="bi bi-chevron-right small" style="color:white;"></i> Contact Us</a>
                        <a href="{{route('terms')}}" class="footer-link"><i class="bi bi-chevron-right small" style="color:white;"></i> Terms & Conditions</a>
                        <a href="{{route('private_Policy')}}" class="footer-link"><i class="bi bi-chevron-right small" style="color:white;"></i> Privacy Policy</a>
                        <a href="{{route('shipping_policy')}}" class="footer-link"><i class="bi bi-chevron-right small" style="color:white;"></i> Shipping & Delivery</a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <h6 class="fw-bold mb-4 text-uppercase text-ylo" style="letter-spacing: 1px;">Store Information</h6>
                    <div class="d-grid gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-geo-alt-fill" style="color:white; font-size: 1.2rem;"></i>
                            <span class="small text-ylo"> Brooke Bond, 13/1b, Krishna samy Mudaliar Road, near Kikani Vidhya Mandir School, Layout, R.S. Puram, Coimbatore, Tamil Nadu 641002</span>
                        </div>
                        <a href="tel:+919876543210" class="d-flex align-items-center gap-3">
                            <i class="bi bi-telephone-fill" style="color:white; font-size: 1.1rem;"></i>
                            <span class="small text-ylo">Call us: +91 9876543210</span>
                        </a>
                    </div>

                    <div class="map-wrapper">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3915.2443491957!2d76.9946!3d11.0772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDA0JzM3LjkiTiA3NsKwNTknNDAuNiJF!5e0!3m2!1sen!2sin!4v1700000000000"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>

            <hr class="my-5 opacity-10">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="small text-ylo mb-0">
                    2026 Copyright By <strong>Anni's Kitchen Products</strong> Powered By <a href="https://webbitech.com/" style="color:white;">Webbitech</a>
                </p>
                <div class="d-flex align-items-center gap-3 opacity-75">
                    <img src="asset/img/visa.png" height="25" alt="Visa">
                    <img src="asset/img/mastercard.png" height="25" alt="Master">
                    <img src="asset/img/amex.png" height="25" alt="Amex">
                </div>

            </div>
        </div>
    </div>
</footer>
<button onclick="scrollToTop()" id="scrollTopBtn" class="action-icon border-0 shadow-lg"
    style="background: #5E0E3C; color: #ffffff; position: fixed; bottom: 30px; right: 30px; z-index: 1000; display: none;">
    <i class="bi bi-chevron-up"></i>
</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="asset/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadNavbarCart();
    });
    function loadNavbarCart() {

    fetch("{{ route('cart.navbar') }}")
        .then(res => res.json())
        .then(data => {

            if (data.status) {

                // Update cart items
                const cartBody = document.getElementById("cartBody");
                if (cartBody) {
                    cartBody.innerHTML = data.html;
                }

                // Update subtotal
                const totalElement = document.getElementById("cartGrandTotal");
                if (totalElement) {
                    totalElement.innerText = data.total;
                }
                const totalCount = document.getElementById("cart-count");
                if (totalCount) {
                    totalCount.innerText = data.cartcount;
                }

            }

        })
        .catch(err => {
            console.error("Navbar Cart Error:", err);
        });
}
function updateQtyNav(el, cartId, change) {

    fetch("{{ route('cart.update', ':id') }}".replace(':id', cartId), {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            change: change
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data.status);
        if (data.status) {
            loadNavbarCart(); // reload full cart from backend
        }

    })
    .catch(err => console.error(err));
    loadNavbarCart(); 
}
$(document).on('click', '.nav-cart-remove', function () {

    let id = $(this).data('id');

    $.ajax({
        url: "{{ route('cart.remove', ':id') }}".replace(':id', id),
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status) {
                loadNavbarCart();
            }
            loadNavbarCart();
        },
        error: function (err) {
            console.log(err);
        }
        
    });

});

</script>