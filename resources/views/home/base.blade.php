<!-- this is the base page for all other pages -->
<!-- this page should be the parent and extended by other pages -->
<!-- all the common css and js references are listed here -->
<!-- derived pages can have their own specific css and js references -->

<!DOCTYPE HTML>
<html>
<head>
<title>CSC667-867 UNO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Fashionpress Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="<?php echo asset('js/jquery.min.js'); ?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="<?php echo asset("js/validator.js"); ?>"></script>

<!-- customized css file -->
<link href="<?php echo asset('css/general.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo asset("css/style.css"); ?>" rel="stylesheet" type="text/css" />

<!-- webfont -->
<link href="https://fonts.googleapis.com/css?family=Lato:100,200,300,400,500,600,700,800,900" rel="stylesheet" type="text/css">
</head>

<body>
{{-- include home.header --}}
@include("home.header")

{{-- yield extended content --}}
@yield("bodycontent")

</body>

</html>