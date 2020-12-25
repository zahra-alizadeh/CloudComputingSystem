<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Marvel HTML Bootstrap 4 Template</title>

    <link rel="stylesheet" href="<?php $this->asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/unicons.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.theme.default.min.css') ?>">

    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="<?php $this->asset('css/tooplate-style.css') ?>">

</head>

<body>

<!-- MENU -->
<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="#about" class="nav-link"><span data-hover="About">About</span></a>
                </li>
                <li class="nav-item">
                    <a href="#project" class="nav-link"><span data-hover="Projects">Projects</span></a>
                </li>
                <li class="nav-item">
                    <a href="#resume" class="nav-link"><span data-hover="Resume">Resume</span></a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link"><span data-hover="Contact">Contact</span></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-lg-auto">
                <div class="ml-lg-4">
                    <div class="color-mode d-lg-flex justify-content-center align-items-center">
                        <i class="color-mode-icon"></i> Color mode
                    </div>
                </div>
            </ul>
        </div>
    </div>
</nav>

<!-- ABOUT -->
<section class="about full-screen d-lg-flex justify-content-center align-items-center" id="about">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-12 col-12 d-flex align-items-center">
                <div class="about-text">
                    <h1 class="animated animated-text">
                        <span class="mr-2">Hey folks, I'm</span>
                        <div class="animated-info">
                            <span class="animated-item">Marvel Sann</span>
                            <span class="animated-item">Web Designer</span>
                            <span class="animated-item">UI Specialist</span>
                        </div>
                    </h1>

                    <p>Building a successful product is a challenge. I am highly energetic in user experience design,
                        interfaces and web development.</p>

                    <div class="custom-btn-group mt-4">
                        <a href="<?php $this->url('user/login'); ?>" class="btn mr-lg-2 custom-btn">Login</a>
                        <a href="<?php $this->url('user/registration'); ?>" class="btn custom-btn custom-btn-bg custom-btn-link">Register</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <div class="about-image svg">
                    <img src="<?php $this->asset('images/Types-of-cloud-storage-05-700x544.png') ?>" class="img-fluid"
                         alt="svg image">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <p class="copyright-text text-center">Copyright &copy; 2019 Company Name . All rights reserved</p>
            </div>
        </div>
    </div>
</footer>

<script src="<?php $this->asset('js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?php $this->asset('js/popper.min.js') ?>"></script>
<script src="<?php $this->asset('js/bootstrap.min.js') ?>"></script>
<script src="<?php $this->asset('js/Headroom.js') ?>"></script>
<script src="<?php $this->asset('js/jQuery.headroom.js') ?>"></script>
<script src="<?php $this->asset('js/owl.carousel.min.js') ?>"></script>
<script src="<?php $this->asset('js/smoothscroll.js') ?>"></script>
<script src="<?php $this->asset('js/custom.js') ?>"></script>
</body>

</html>