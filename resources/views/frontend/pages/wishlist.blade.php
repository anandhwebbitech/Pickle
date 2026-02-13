@extends('frontend.layouts.app')
@section('content')
<div class="yp-wishlist-header mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="yp-page-title mb-1">My Wishlist</h1>
                <p class="text-muted mb-0">Items you've saved for later.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{route('product')}}" class="btn btn-outline-dark rounded-pill fw-bold px-4">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4" id="wishlist-container">
        <!-- AJAX Products Load Here -->
    </div>
</div>
@push('scripts')

<script>

// Load on page load
document.addEventListener("DOMContentLoaded", function () {
    loadWishlist();
});
function loadWishlist() {

    fetch("{{ route('wishlist.data') }}")
    .then(response => response.json())
    .then(data => {

        if (data.status) {
            document.getElementById('wishlist-container').innerHTML = data.html;
        } else {
            document.getElementById('wishlist-container').innerHTML =
                '<div class="col-12 text-center">Something went wrong</div>';
        }

    })
    .catch(error => {
        console.error(error);
        document.getElementById('wishlist-container').innerHTML =
            '<div class="col-12 text-center text-danger">Server Error</div>';
    });
}
</script>
@endpush

@endsection