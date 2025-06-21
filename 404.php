<?php
// Function to get the current page URL
function getCurrentPageUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    
    return $protocol . $host . $uri;
}

// Print the current page URL
// echo getCurrentPageUrl();
// echo $_SERVER['REQUEST_URI'];;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- css -->
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="la-themes">
    <title>Page Not Found</title>


<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet">

<!--font-awesome-css-->
<link rel="stylesheet" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/fontawesome/css/all.css">

<!--animation-css-->
<link rel="stylesheet" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/animation/animate.min.css">

<!-- iconoir icon css  -->
<link href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/ionio-icon/css/iconoir.css" rel="stylesheet">

<!-- tabler icons-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/tabler-icons/tabler-icons.css">

<!--flag Icon css-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/flag-icons-master/flag-icon.css">

<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/bootstrap/bootstrap.min.css">

<!--  prism CSS-->
<link href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/prism/prism.min.css" rel="stylesheet">

<!-- simplebar css-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/simplebar/simplebar.css">

<!-- App css-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/css/style.css">

<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/css/responsive.css"></head>


</head>
<body>
<div class="error-container p-0">
    <div class="container">
        <div>
            <div>
                <img src="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/images/background/error-404.png" class="img-fluid" alt="">
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 ">
                        <p class="text-center text-secondary f-w-500">Website owners should regularly check for and fix broken links using tools like Google Search Console or other link-checking software.</p>
                    </div>
                </div>
            </div>
            <a role="button" href="/" class="btn btn-lg btn-light-primary b-r-22"><i class="ti ti-home"></i> Back To Home</a>
        </div>
    </div>
</div>

<!-- essential   -->
<!-- latest jquery-->
<script src="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/js/jquery-3.6.3.min.js"></script>

<!-- Bootstrap js-->
<script src="https://phpstack-1384472-5196432.cloudwaysapps.com/assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>


</body>


</html>
