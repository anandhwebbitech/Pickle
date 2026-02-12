document.addEventListener("click", function (e) {
  if (e.target.classList.contains("btn-plus")) {
    let item = e.target.closest(".cart-item");
    let q = item.querySelector(".qty");
    q.innerText = parseInt(q.innerText) + 1;
    updateItem(item);
  }
  if (e.target.classList.contains("btn-minus")) {
    let item = e.target.closest(".cart-item");
    let q = item.querySelector(".qty");
    if (parseInt(q.innerText) > 1) {
      q.innerText = parseInt(q.innerText) - 1;
      updateItem(item);
    }
  }
  if (e.target.closest(".btn-remove")) {
    e.target.closest(".cart-item").remove();
    calculateGrand();
  }
});

function updateItem(item) {
  let price = parseInt(item.getAttribute("data-price"));
  let qty = parseInt(item.querySelector(".qty").innerText);
  item.querySelector(".item-total").innerText = price * qty;
  calculateGrand();
}

function calculateGrand() {
  let totals = document.querySelectorAll(".item-total");
  let sum = 0;
  totals.forEach((t) => (sum += parseInt(t.innerText)));
  document.getElementById("grandTotal").innerText = sum;
  document.querySelector(".cart-count").innerText = totals.length;
  if (totals.length === 0) {
    document.getElementById("cartBody").innerHTML =
      "<div class='text-center mt-5 text-muted'><i class='bi bi-cart-x fs-1 d-block mb-3'></i>Cart is empty</div>";
  }
}

function addToCart(name, price, imageSrc) {
  const cartBody = document.getElementById("cartBody");
  const newItemHTML = `
            <div class="cart-item d-flex align-items-center mb-4 p-3 bg-light rounded-4" data-price="${price}">
                <div class="cart-img-container me-3">
                    <img src="${imageSrc}" alt="${name}" class="rounded-3 shadow-sm">
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold">${name}</h6>
                    <div class="d-flex align-items-center mt-2 gap-3">
                        <div class="d-flex align-items-center bg-white rounded-pill px-2 border">
                            <span class="btn-minus p-1" style="cursor:pointer;">-</span>
                            <span class="qty fw-bold mx-2">1</span>
                            <span class="btn-plus p-1" style="cursor:pointer;">+</span>
                        </div>
                        <div class="fw-bold text-calor">₹<span class="item-total">${price}</span></div>
                    </div>
                </div>
                <button class="btn btn-sm text-muted btn-remove ms-2"><i class="bi bi-x-circle-fill fs-5"></i></button>
            </div>`;
  if (cartBody.innerHTML.includes("Cart is empty")) cartBody.innerHTML = "";
  cartBody.insertAdjacentHTML("beforeend", newItemHTML);
  calculateGrand();
}
// Fix: Automatically close mobile menu when switching to desktop view
window.addEventListener("resize", function () {
  if (window.innerWidth >= 992) {
    const mobileMenuEl = document.getElementById("mobileNav");
    const modalInstance = bootstrap.Offcanvas.getInstance(mobileMenuEl);

    // If the menu is currently open, hide it
    if (modalInstance) {
      modalInstance.hide();
    }
  }
});

// Scroll to Top Button Functionality
// Get the button
const scrollTopBtn = document.getElementById("scrollTopBtn");

// When the user scrolls down 300px from the top, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 300 ||
    document.documentElement.scrollTop > 300
  ) {
    scrollTopBtn.style.display = "flex";
  } else {
    scrollTopBtn.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth", // This makes it a smooth glide instead of a jump
  });
}

// hero slider
// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  const swiper = new Swiper(".bannerSwiper", {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
});

// product slider
document.addEventListener("DOMContentLoaded", function () {
  // Correct 4-view Slider Settings
  const swiper = new Swiper("#mainSlider", {
    slidesPerView: 1, // Mobile
    spaceBetween: 25,
    loop: true, // Infinite Loop
    autoplay: { delay: 3500, disableOnInteraction: false },
    navigation: {
      nextEl: "#p-next",
      prevEl: "#p-prev",
    },
    breakpoints: {
      576: { slidesPerView: 2 }, // Tablet
      992: { slidesPerView: 4 }, // Desktop: Shows 4 items
    },
  });
});

function updateQty(btn, val) {
  const display = btn.parentElement.querySelector(".local-qty");
  let count = parseInt(display.innerText) + val;
  if (count < 1) count = 1;
  display.innerText = count;
}

// function toggleSave(btn) {

//     let productId = btn.getAttribute("data-id");

//     fetch("toggle-wishlist/" + productId, {
//         method: "POST",
//        headers: {
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//             "Content-Type": "application/json",
//             "Accept": "application/json"
//         },
//         credentials: "same-origin"
//     })
//     .then(res => res.json())
//     .then(data => {

//         const icon = btn.querySelector("i");

//         if (data.added) {
//             btn.classList.add("active");
//             icon.classList.remove("bi-heart");
//             icon.classList.add("bi-heart-fill", "text-danger");
//         } else {
//             btn.classList.remove("active");
//             icon.classList.remove("bi-heart-fill", "text-danger");
//             icon.classList.add("bi-heart");
//         }

//         let badge = document.querySelector(".wishlist-link .badge");
//         if (badge) {
//             badge.innerText = data.count;
//         }

//     })
//     .catch(err => console.log(err));
// }
function toggleSave(btn) {

    let productId = btn.getAttribute("data-id");

    fetch("toggle-wishlist/" + productId, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        credentials: "same-origin"
    })
    .then(res => res.json())
    .then(data => {

        const icon = btn.querySelector("i");

        if (data.added) {

            // Added to wishlist
            btn.classList.add("active");
            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill", "text-danger");

        } else {

            // Removed from wishlist
            btn.classList.remove("active");
            icon.classList.remove("bi-heart-fill", "text-danger");
            icon.classList.add("bi-heart");

            // 🔥 Reload wishlist page items
            if (document.getElementById("wishlist-container")) {
                loadWishlist();
            }
        }

        // Update badge count
        let badge = document.querySelector(".wishlist-link .badge");
        if (badge) {
            badge.innerText = data.count;
        }

    })
    .catch(err => console.log(err));
}

// function handleCartClick(btn) {
//   const qty = btn
//     .closest(".product-card")
//     .querySelector(".local-qty").innerText;
//   btn.innerHTML = `<i class="bi bi-check-circle me-2"></i>Added ${qty}`;
//   btn.classList.replace("btn-dark", "btn-success");
//   setTimeout(() => {
//     btn.innerHTML = "Add to Cart";
//     btn.classList.replace("btn-success", "btn-dark");
//   }, 2000);
// }

// 2nd swiper
// Initialization for the SECOND slider
const trendingSwiper = new Swiper(".trendingSwiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  navigation: {
    nextEl: "#p-next-2", // Targets the NEW next button
    prevEl: "#p-prev-2", // Targets the NEW prev button
  },
  breakpoints: {
    640: { slidesPerView: 2 },
    768: { slidesPerView: 3 },
    1024: { slidesPerView: 4 },
  },
});

// 3rd swiper
// Initialize the second swiper
const pickleSwiper = new Swiper(".pickleSwiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  navigation: {
    nextEl: "#p-next-3", // Points to the new unique next button
    prevEl: "#p-prev-3", // Points to the new unique prev button
  },
  breakpoints: {
    // When window width is >= 640px
    640: { slidesPerView: 2 },
    // When window width is >= 768px
    768: { slidesPerView: 3 },
    // When window width is >= 1024px
    1024: { slidesPerView: 4 },
  },
});

// product details
// 1. Initialize Swipers
const swiperThumbs = new Swiper(".thumb-swiper", {
  spaceBetween: 10,
  slidesPerView: 4,
  watchSlidesProgress: true,
});
const swiperMain = new Swiper(".main-swiper", {
  spaceBetween: 10,
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  thumbs: { swiper: swiperThumbs },
});

// 2. Quantity Logic
function updateQty(n) {
  let q = parseInt(document.getElementById("qty-count").innerText);
  q += n;
  if (q < 1) q = 1;
  document.getElementById("qty-count").innerText = q;
}

// 3. Price Toggle
function changePrice(btn, price) {
  document
    .querySelectorAll(".gram-btn")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
  document.getElementById("price-target").innerText = price.toFixed(2);
}

// 4. Wishlist Toggle (REFINED)
function toggleWishlist(btn) {
  btn.classList.toggle("active");
  const icon = btn.querySelector("i");
  if (btn.classList.contains("active")) {
    icon.classList.replace("bi-heart", "bi-heart-fill");
  } else {
    icon.classList.replace("bi-heart-fill", "bi-heart");
  }
}

// 5. Social Share
function social(p) {
  const u = encodeURIComponent(window.location.href);
  const url =
    p === "fb"
      ? `https://www.facebook.com/sharer/sharer.php?u=${u}`
      : `https://api.whatsapp.com/send?text=${u}`;
  window.open(url, "_blank", "width=600,height=400");
}

// 6. Copy Link
function copyToClip() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    const btn = document.getElementById("clip-btn");
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied';
    btn.className =
      "btn btn-sm btn-success text-white rounded-pill px-3 ms-md-auto";
    setTimeout(() => {
      btn.innerHTML = originalHTML;
      btn.className =
        "btn btn-sm btn-outline-dark rounded-pill px-3 ms-md-auto";
    }, 2500);
  });
}

// checkout
function handlePayment() {
  const isRazorpay = document.getElementById("razorpay").checked;
  if (isRazorpay) {
    alert("Opening Razorpay Gateway...");
  } else {
    alert("Order Placed via COD!");
  }
}
function handleCartClick(btn) {

    let url = btn.getAttribute("data-url");

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Accept": "application/json"
        },
        credentials: "same-origin"
    })
    .then(res => res.json())
    .then(data => {

        if (data.status) {

            // ✅ Update cart badge
            let badge = document.querySelector(".cart-link .badge");
            if (badge) {
                badge.innerText = data.count;
            }

            // ✅ Button animation
            const originalText = btn.innerHTML;

            btn.innerHTML = `<i class="bi bi-check-circle me-2"></i>Added`;
            btn.classList.remove("btn-dark");
            btn.classList.add("btn-success");

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove("btn-success");
                btn.classList.add("btn-dark");
            }, 2000);

        } else {

            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message
            });

        }

    })
    .catch(err => {
        console.log(err);
        Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Something went wrong!'
        });
    });
}

