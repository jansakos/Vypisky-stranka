	<meta http-equiv="Content-Security-Policy" content="default-src 'self' https://fonts.googleapis.com 'unsafe-inline'; 
	img-src *; 
	script-src https://oss.maxcdn.com/  'self' 'sha256-rGI7kIEt01fJWy6GhnN9OLc2ltBmBFZPszVxkO/qqlI=' 'sha256-cMfpe2CMvL9p52zgEa1SPCAX2miB7XB+u3xzfV+2LIA=' 'sha256-EJQ4DF/t6taagnA04EJPfHppGjWAsaTUThXB/P5bZU4=' 'sha256-6jyBQ7jNjfTNWYwqaP3Zj95ilNzAQY8L6y6t0VbC26M=' 'sha256-2jNptEFL4D8wEVpcBcgbnTCWBSLFq04jZ7r8BqK4Qtw=' 'sha256-f7hh68d5vOfdo8M8+l9NpiVfzeNliDaiJD5bhu5G+Ms=';
	object-src 'none';
	font-src https://fonts.googleapis.com https://fonts.gstatic.com/ 'self' data:">	
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Výpisky Jarošky">
    <meta name="author" content="Jan Sako">
	<meta name="theme-color" content="#2d2d2d">
	<meta name="msapplication-navbutton-color" content="#2d2d2d">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="V&yacute;pisky">
	<meta name="application-name" content="V&yacute;pisky">
	<meta name="msapplication-TileColor" content="#d55400">
	<meta name="msapplication-TileImage" content="assets/ico/mstile-144x144.png?v=lk9El2XkA0">
	<meta name="msapplication-config" content="assets/ico/browserconfig.xml?v=lk9El2XkA0">
	<meta name="keywords" content="Vypisky, OSS, Open School System for Students, OSSfS">

	<link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png?v=lk9El2XkA0">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png?v=lk9El2XkA0">
	<link rel="icon" type="image/png" sizes="194x194" href="assets/ico/favicon-194x194.png?v=lk9El2XkA0">
	<link rel="icon" type="image/png" sizes="192x192" href="assets/ico/android-chrome-192x192.png?v=lk9El2XkA0">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png?v=lk9El2XkA0">
	<link rel="manifest" href="assets/manifest/site.webmanifest?v=lk9El2XkA0">
	<link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg?v=lk9El2XkA0" color="#5bbad5">
	<link rel="shortcut icon" href="assets/ico/favicon.ico?v=lk9El2XkA0">
	<link rel="alternate" type="application/rss+xml" title="RSS Výpisků" href="<?=$domainname ?>/test/rss/index.php" />

	<?php
		header("X-XSS-Protection: 1; mode=block");
		header('X-Frame-Options: SAMEORIGIN');
		header('X-Content-Type-Options: nosniff');
		header('Referrer-Policy: no-referrer');
	?>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	
	<script src="assets/js/alert.js"></script>