<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- fONT awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite('resources/js/app.js')
    <style>
        .hero-section {
            background-size: cover;
            background-position: center;
            color: black;
            padding: 150px 0;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .testimonial-section {
            background-color: #f8f9fa;
        }

        .cta-section {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>

<body>
    <x-navbar></x-navbar>
    {{-- Hero Section --}}
    <section id="home" class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Selamat Datang di Unities</h1>
            <p class="lead mb-4">Platform yang menghubungkan seluruh mahasiswa Indonesia untuk berkolaborasi dan
                berkembang
                bersama</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Bergabung Sekarang</a>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-users feature-icon"></i>
                        <h3>Komunitas Mahasiswa</h3>
                        <p>Bergabung dengan ribuan mahasiswa dari berbagai universitas di Indonesia.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-laptop-code feature-icon"></i>
                        <h3>Proyek Kolaboratif</h3>
                        <p>Kerjakan proyek bersama mahasiswa lain dan tingkatkan portfolio Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-graduation-cap feature-icon"></i>
                        <h3>Sharing Pengetahuan</h3>
                        <p>Berbagi dan dapatkan pengetahuan dari sesama mahasiswa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section id="testimonials" class="testimonial-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Apa Kata Mereka?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">"Unities membantu saya menemukan teman-teman yang sepassion untuk
                                mengerjakan proyek bersama."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" class="rounded-circle me-3" alt="Testimonial">
                                <div>
                                    <h5 class="mb-0">Ahmad Fauzi</h5>
                                    <small class="text-muted">Mahasiswa UI</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">"Platform yang sangat membantu untuk mendapatkan insight dari mahasiswa
                                universitas lain."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" class="rounded-circle me-3" alt="Testimonial">
                                <div>
                                    <h5 class="mb-0">Sarah Diana</h5>
                                    <small class="text-muted">Mahasiswa ITB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">"Berkat Unities, saya bisa mengembangkan soft skill dan hard skill
                                secara
                                bersamaan."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="/api/placeholder/50/50" class="rounded-circle me-3" alt="Testimonial">
                                <div>
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <small class="text-muted">Mahasiswa UGM</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="cta-section py-5">
        <div class="container text-center">
            <h2 class="mb-4">Siap Bergabung dengan Komunitas Unities?</h2>
            <p class="lead mb-4">Download aplikasi sekarang dan mulai perjalanan Anda bersama ribuan mahasiswa lainnya!
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    Gabung Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Tentang Unities</h5>
                    <p>Platform kolaborasi mahasiswa Indonesia untuk berbagi pengetahuan dan mengembangkan potensi
                        bersama.
                    </p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">FAQ</a></li>
                        <li><a href="#" class="text-light">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-light">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-light">Bantuan</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i>info@unities.id</li>
                        <li><i class="fas fa-phone me-2"></i>(021) 1234-5678</li>
                        <li class="mt-3">
                            <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <small>&copy; 2024 Unities. All rights reserved.</small>
            </div>
        </div>
    </footer>
    {{-- JS Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
