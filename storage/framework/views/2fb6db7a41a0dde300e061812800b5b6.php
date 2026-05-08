<?php $__env->startSection('title', 'Fakhri Kitchen - Catering Premium Bogor'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="hero-title">
                    Discover Culinary <span>Excellence</span> with Fakhri Kitchen
                </h1>
                <p class="hero-subtitle">
                    Nikmati pengalaman kuliner terbaik dengan layanan catering premium kami.
                    Dari prasmanan mewah hingga meal box praktis, setiap hidangan dibuat
                    dengan cinta dan bahan berkualitas terbaik.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-cta btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
                    </a>
                    <a href="#offerings" class="btn btn-outline-cta btn-lg">
                        <i class="bi bi-play-circle me-2"></i>Lihat Menu
                    </a>
                </div>
                <div class="row mt-5">
                    <div class="col-4 text-center">
                        <h3 class="fw-bold text-primary mb-0">500+</h3>
                        <small class="text-muted">Pesanan Selesai</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="fw-bold text-primary mb-0">50+</h3>
                        <small class="text-muted">Menu Pilihan</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="fw-bold text-primary mb-0">4.9</h3>
                        <small class="text-muted">Rating ⭐</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    
                    <img src="<?php echo e(asset('images/landing/hero-food.jpg')); ?>" alt="Catering Fakhri Kitchen" class="hero-image">
                    <div class="hero-badge">
                        <i class="bi bi-award"></i> Premium Quality Since 2024
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="values-section" id="values">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-white">Our Core Values</h2>
            <p class="text-white-50">Komitmen kami untuk memberikan yang terbaik</p>
        </div>
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <i class="bi bi-fire value-icon"></i>
                    <h5>Excellence</h5>
                    <p>Unforgettable culinary experiences</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <i class="bi bi-lightbulb value-icon"></i>
                    <h5>Innovation</h5>
                    <p>Dynamic, fresh, exciting flavors</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <i class="bi bi-gem value-icon"></i>
                    <h5>Quality</h5>
                    <p>Source to plate culinary delights</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <i class="bi bi-leaf value-icon"></i>
                    <h5>Sustainability</h5>
                    <p>Eco-friendly dining practices</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="offerings-section" id="offerings">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Our Offerings</h2>
            <p class="section-subtitle">Pilih paket catering yang sesuai dengan kebutuhan Anda</p>
        </div>
        <div class="row g-4">
            
            <div class="col-lg-3 col-md-6">
                <div class="offering-card">
                    
                    <img src="<?php echo e(asset('images/landing/offering-buffet.jpg')); ?>" alt="Prasmanan">
                    <div class="card-body">
                        <h5>Prasmanan</h5>
                        <p>Sajian lengkap dengan berbagai pilihan menu untuk acara besar Anda.</p>
                        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-offering mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-3 col-md-6">
                <div class="offering-card">
                    
                    <img src="<?php echo e(asset('images/landing/offering-mealbox.jpg')); ?>" alt="Meal Box">
                    <div class="card-body">
                        <h5>Meal Box</h5>
                        <p>Nasi box praktis dengan porsi pas dan cita rasa terbaik.</p>
                        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-offering mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-3 col-md-6">
                <div class="offering-card">
                    
                    <img src="<?php echo e(asset('images/landing/offering-snackbox.jpg')); ?>" alt="Snack Box">
                    <div class="card-body">
                        <h5>Snack Box</h5>
                        <p>Camilan lezat untuk meeting, seminar, atau acara santai Anda.</p>
                        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-offering mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-3 col-md-6">
                <div class="offering-card">
                    
                    <img src="<?php echo e(asset('images/landing/offering-tumpeng.jpg')); ?>" alt="Tumpeng">
                    <div class="card-body">
                        <h5>Tumpeng</h5>
                        <p>Tumpeng spesial untuk syukuran, ulang tahun, dan perayaan.</p>
                        <a href="<?php echo e(route('customer.catalog')); ?>" class="btn btn-offering mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="gallery-section" id="gallery">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Visual Gallery</h2>
            <p class="section-subtitle">Intip kelezatan hidangan kami</p>
        </div>
        <div class="gallery-grid">
            
            <div class="gallery-item">
                <img src="<?php echo e(asset('images/landing/gallery-1.jpg')); ?>" alt="Gallery 1">
            </div>
            
            <div class="gallery-item">
                <img src="<?php echo e(asset('images/landing/gallery-2.jpg')); ?>" alt="Gallery 2">
            </div>
            
            <div class="gallery-item">
                <img src="<?php echo e(asset('images/landing/gallery-3.jpg')); ?>" alt="Gallery 3">
            </div>
            
            <div class="gallery-item">
                <img src="<?php echo e(asset('images/landing/gallery-4.jpg')); ?>" alt="Gallery 4">
            </div>
            
            <div class="gallery-item">
                <img src="<?php echo e(asset('images/landing/gallery-5.jpg')); ?>" alt="Gallery 5">
            </div>
        </div>
    </div>
</section>


<section class="testimonials-section" id="testimonials">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Testimoni dari pelanggan setia kami</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p>"Fakhri Kitchen's catering service transformed our wedding reception into a truly unforgettable culinary experience. The flavors were exceptional!"</p>
                    <div class="testimonial-author">
                        
                        <img src="<?php echo e(asset('images/landing/testimonial-1.jpg')); ?>" alt="Sarah" class="testimonial-avatar">
                        <div>
                            <h6>Sarah Putri</h6>
                            <small>Wedding Event</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p>"We ordered meal boxes for our corporate event and everyone loved it. Great variety, delicious food, and always on time!"</p>
                    <div class="testimonial-author">
                        
                        <img src="<?php echo e(asset('images/landing/testimonial-2.jpg')); ?>" alt="Ahmad" class="testimonial-avatar">
                        <div>
                            <h6>Ahmad Rizky</h6>
                            <small>Corporate Event</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p>"The cooking class I attended was educational but incredibly fun! The team is professional and the tumpeng was gorgeous."</p>
                    <div class="testimonial-author">
                        
                        <img src="<?php echo e(asset('images/landing/testimonial-3.jpg')); ?>" alt="Diana" class="testimonial-avatar">
                        <div>
                            <h6>Diana Sari</h6>
                            <small>Syukuran Event</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="cta-section">
    <div class="container">
        <h2>Ready to Elevate Your Culinary Journey?</h2>
        <p>Hubungi kami sekarang dan dapatkan penawaran spesial untuk acara Anda!</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo e(route('register')); ?>" class="btn btn-cta-white btn-lg">
                <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
            </a>
            <a href="https://wa.me/6281234567890" class="btn btn-outline-light btn-lg" style="border-radius: 50px; padding: 0.8rem 2rem; font-weight: 600;">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp Kami
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SAAS-AKHIR-LARAVEL\resources\views/landing.blade.php ENDPATH**/ ?>