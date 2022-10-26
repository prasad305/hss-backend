<meta charset="utf-8" />
<title> @stack('title') | {{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="Admin Dashboard" name="description" />
<meta content="ThemeDesign" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />


<link rel="shortcut icon" href=" {{ asset('assets/manager-admin/images/favicon.ico') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
@stack('datatableCSS')

<link href=" {{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<link href=" {{ asset('assets/manager-admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href=" {{ asset('assets/manager-admin/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href=" {{ asset('assets/manager-admin/css/style.css') }}" rel="stylesheet" type="text/css">
<link href=" {{ asset('assets/manager-admin/css/_dropdown.css') }}" rel="stylesheet" type="text/css">



<!--====== AJAX ======-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




@stack('css')
