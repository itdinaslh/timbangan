<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Timbangan Bantargebang" />
	
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>@yield('Title') - UPST TIMBANGAN</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon"  href="/images/logo/logodlh.ico" />
	
	<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="/vendor/nouislider/nouislider.min.css">
	<!-- Style css -->
    <link href="/css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	@livewireStyles
@stack('styles')