<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Gallery | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">


    <link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css')}}">




</head>

<body>


<div class="row gallery-wrapper">
    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development1">
        <div class="gallery-box card">
            <div class="gallery-container">
                <a class="image-popup" href="{{ URL::asset('build/images/small/img-1.jpg')}}" title="">
                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('build/images/small/img-1.jpg')}}" alt="" />
                    <div class="gallery-overlay">
                        <h5 class="overlay-caption">Glasses and laptop from above</h5>
                    </div>
                </a>
            </div>

            <div class="box-content">
                <div class="d-flex align-items-center mt-1">
                    <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ron Mackie</a></div>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.2K
                            </button>
                            <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3K
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
        <div class="gallery-box card">
            <div class="gallery-container">
                <a class="image-popup" href="{{ URL::asset('build/images/small/img-12.jpg')}}" title="">
                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('build/images/small/img-12.jpg')}}" alt="" />
                    <div class="gallery-overlay">
                        <h5 class="overlay-caption">A mix of friends and strangers heading off to find an adventure.</h5>
                    </div>
                </a>
            </div>

            <div class="box-content">
                <div class="d-flex align-items-center mt-1">
                    <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Erica Kernan</a></div>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 3.4K
                            </button>
                            <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3k
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{ URL::asset('build/js/pages/gallery.init.js')}}"></script>




</body>

</html>
