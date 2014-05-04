<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	
	<!-- Page Title -->
	<title>CodeJam</title>
	
	<meta name="keywords" content="php, software, css, html" />
	<meta name="description" content="codejam portfolio website" />
	
	<!-- Mobile Meta Tag -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="<?=Util::baseUrl('public/images').'/';?>/fav_touch_icons/favicon.jpg" />
	<link rel="apple-touch-icon" href="<?=Util::baseUrl('public/images').'/';?>/fav_touch_icons/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?=Util::baseUrl('public/images').'/';?>/fav_touch_icons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?=Util::baseUrl('public/images').'/';?>/fav_touch_icons/apple-touch-icon-114x114.png" />
	
	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> 
	<![endif]-->
	
	<!-- Google Web Font -->
	<link href='http://fonts.googleapis.com/css?family=Economica|Source+Sans+Pro' rel='stylesheet' type='text/css' />
	
	<!-- Bootstrap CSS -->
	<link href="<?=Util::css('bootstrap.css');?>" rel="stylesheet" />
	
	<!-- FontAwesome CSS -->
	<link href="<?=Util::css('font-awesome.css');?>" rel="stylesheet" />
	
	<!-- Custom LESS CSS -->
	<link rel="stylesheet/less" type="text/css" href="<?=Util::css('style.less');?>" />
	
	<!-- Modernizr -->
	<script src="<?=Util::js('modernizr-2.6.2.min.js');?>"></script>
	
	<!-- LESS CSS Script -->
	<script type="text/javascript">
		less = {
			env: "production", // or "production"
			async: false,       // load imports async
			fileAsync: false,   // load imports async when in a page under
								// a file protocol
			relativeUrls: false,// whether to adjust url's to be relative
								// if false, url's are already relative to the
								// entry less file
			rootpath: "http://localhost/CodeJam/public/css/"// a path to add on to the start of every url resource
																// Change it to your own server path
		};
	</script>
	<script src="<?=Util::js('less-1.4.2.min.js');?>"></script>
	
</head>
<body>
	<!-- BEGIN HEADER -->
	<header id="header">
		<div class="container">
			<div class="row"><a href="#header" id="logo" class="nav-button"><<?=Util::baseUrl('public/images').'/';?> src="<?=Util::baseUrl('public/images').'/';?>/logo.png" alt="" width="550px" height="150px" /></a></div>
		</div>
	</header>
	<!-- END HEADER -->
	
	<div id="wrap">
		<section class="nav-section">
			<a href="#header" class="nav-button"><<?=Util::baseUrl('public/images').'/';?> src="<?=Util::baseUrl('public/images').'/';?>/logo_short.png" alt="" width="110px" height="56px" /></a>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<nav id="nav"><!-- Begin Main Menu -->
							<ul class="sf-menu">
								<li><a href="#header" class="icon" data-id="Home"><i class="icon-home"></i></a></li>
								<li><a href="#portfolio">Portfolio</a></li>
								<li><a href="#services">Our Services</a></li>
								<li>
									<a href="#about">About Us</a>
									<ul>
										<li><a href="#" id="nav-submenu1">Submenu #1</a></li>
										<li><a href="#" id="nav-submenu2">Submenu #2</a></li>
										<li><a href="#" id="nav-submenu3">Submenu #3</a></li>
									</ul>
								</li>
								<li><a href="#contacts">Contacts</a></li>
							</ul>
						</nav><!-- End Main Menu -->
					</div>
				</div>
			</div>
		</section>
		
		<section id="portfolio">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1 class="section-title col-sm-6">Portfolio</h1>
						<p class="section-desc col-sm-6 center">Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
						
						<div id="portfolio-grid">
							<ol id="filters">
								<li data-filter="" class="active">Show All</li>
								<li data-filter="design">Design</li>
								<li data-filter="development">Development</li>
								<li data-filter="dd">Design + Development</li>
								<li data-filter="3d">3D</li>
							</ol>
							
							<ul id="folio-items">
								<li data-filter-class='["design"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x300" alt="" width="300px" height="300px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Responsive One-Page Porfolio</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x250" alt="" width="300px" height="250px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x375" alt="" width="300px" height="375px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["design"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x192" alt="" width="300px" height="192px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x353" alt="" width="300px" height="353px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
								  <<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x278" alt="" width="300px" height="278px" />
								  <div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["design"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x489" alt="" width="300px" height="489px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x185" alt="" width="300px" height="185px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x336" alt="" width="300px" height="336px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["design"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x295" alt="" width="300px" height="295px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x300" alt="" width="300px" height="300px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x250" alt="" width="300px" height="250px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["3d"]'
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x375" alt="" width="300px" height="375px" />
									<div>
										<span class="tags"><a href="">#WiselyThemes</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								
								
								<li data-filter-class='["design"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x192" alt="" width="300px" height="192px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x353" alt="" width="300px" height="353px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x278" alt="" width="300px" height="278px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["design"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x489" alt="" width="300px" height="489px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["development"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x185" alt="" width="300px" height="185px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["dd"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x336" alt="" width="300px" height="336px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
								<li data-filter-class='["3d"]' class="disable"
									data-overview='[{
										"headerBg":"http://placehold.it/1920x500",
										"logo":"http://placehold.it/275x70",
										"description":"Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.",
										"url":"www.wiselythemes.com/mochito",
										"<?=Util::baseUrl('public/images').'/';?>s":[
											{
												"title":"Mochito Template",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x623"
											},
											{
												"title":"Website Preview",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x770"
											},
											{
												"title":"Responsive Design",
												"description":"Lorem ipsum dolor sit amet",
												"<?=Util::baseUrl('public/images').'/';?>":"http://placehold.it/1170x677"
											},
											{
												"title":"Viemo Video Embed",
												"description":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/7449107"
											},
											{
												"title":"YouTube Video Embed",
												"description":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
										}]'>
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/300x295" alt="" width="300px" height="295px" />
									<div>
										<span class="tags"><a href="">#Wisely</a>, <a href="">#Template</a>, <a href="">#Responsive</a></span>
										<div class="info">
											<h2>Mochito</h2>
											<h5>Lorem ipsum dolor sit amet</h5>
											<a href="" class="btn btn-small btn-folio">View project ></a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					
					<div class="col-sm-12 center"><a href="" id="load-works" class="btn btn-large">Load More Works...</a></div>
				</div>
			</div>
		</section>
		
		<section id="services">
			<div id="services-<?=Util::baseUrl('public/images').'/';?>" class="parallax"></div>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1 class="section-title col-sm-6">Services</h1>
						<p class="section-desc col-sm-6 center">Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
					</div>
				</div>
			</div>
			<div id="services-container">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 clearfix">
							<div class="services-item col-sm-3">
								<i class="icon-desktop"></i>
								<h3>Web Design <span>& </span>Development</h3>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
							<div class="services-item col-sm-3">	
								<i class="icon-thumbs-up-alt"></i>
								<h3>Apps, Contests <span>& </span>Sweepstakes</h3>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
							<div class="services-item col-sm-3">
								<i class="icon-mobile-phone"></i>
								<h3>Mobile Apps <span>& </span>Contents</h3>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
							<div class="services-item col-sm-3">
								<i class="icon-picture"></i>
								<h3>Social Media <span>& </span>Web Content</h3>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
						</div>
						
						<div class="col-sm-12 center"><a href="#contacts" id="workwithus" class="btn btn-large full-color">Want to work with us?</a></div>
					</div>
				</div>
			</div>
		</section>
		
		<section id="about">
			<div id="about-<?=Util::baseUrl('public/images').'/';?>" class="parallax"></div>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1 class="section-title col-sm-6">About</h1>
						<p class="section-desc col-sm-6 center">Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="row" id="team">
							<div class="team-member">
								<div class="team-member-<?=Util::baseUrl('public/images').'/';?>">
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/368x368" alt="" width="368px" height="368px" />
									<h2>John Doe <span>WEB DEVELOPER</span></h2>
								</div>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
							<div class="team-member">
								<div class="team-member-<?=Util::baseUrl('public/images').'/';?>">
									<<?=Util::baseUrl('public/images').'/';?> src="http://placehold.it/368x368" alt="" width="368px" height="368px" />
									<h2>Mary Doe <span>WEB DESIGNER</span></h2>
								</div>
								<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-4" id="skills">
						<h4>Our Skills</h4>
						
						<div class="progress" data-percentage="92"><span>HTML5 / CSS3</span><div class="bar"></div></div>
						<div class="progress" data-percentage="75"><span>PHP</span><div class="bar"></div></div>
						<div class="progress" data-percentage="84"><span>JavaScript</span><div class="bar"></div></div>
						<div class="progress" data-percentage="80"><span>MySql</span><div class="bar"></div></div>
						<div class="progress" data-percentage="91"><span>Photoshop</span><div class="bar"></div></div>
						<div class="progress" data-percentage="72"><span>Illustrator</span><div class="bar"></div></div>
						<div class="progress" data-percentage="64"><span>Flash</span><div class="bar"></div></div>
						
						<i class="icon-cogs"></i>
						<h3 class="center">And we are getting<br/> better every day...</h3>
					</div>
				</div>
			</div>
		</section>
		
		<section id="contacts">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1 class="section-title col-sm-6">Contact us</h1>
						<p class="section-desc col-sm-6 center">Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
						
						<ul id="form-opt">
							<li data-id="0" class="active">General Contact</li>
							<li data-id="1" >Request proposal</li>
						</ul>
						
						<form id="form-contact" method="post" action="#">
							<div class="col-sm-6 center"><input type="text" placeholder="Name" name="contact_name" id="contact_name" /></div>
							<div class="col-sm-6 center"><input type="email" placeholder="Email" name="contact_email" id="contact_email" /></div>
							<div class="col-sm-6 center input-hide"><input type="text" placeholder="Company" name="contact_company" id="contact_company" /></div>
							<div class="col-sm-6 center input-hide"><input type="text" placeholder="Budget" name="contact_budget" id="contact_budget" /></div>
							<div class="col-sm-6 center"><textarea cols="6" rows="4" placeholder="Message" name="contact_message" id="contact_message"></textarea></div>
							<div class="col-sm-12 center"><a href="" id="contact_send" class="btn btn-large btn-icon white"><i class="icon-envelope-alt"></i>Send</a></div>
						</form>
					</div>
						
					<span class="contacts-info col-sm-4"><i class="icon-map-marker"></i> 24th Street, New York, USA</span>
					<span class="contacts-info col-sm-4"><i class="icon-phone"></i> 555 123 456 789</span>
					<span class="contacts-info col-sm-4"><i class="icon-envelope-alt"></i> <a href="mailto:support@wiselythemes.com">support@wiselythemes.com</a></span>
				</div>
			</div>
			
			<div id="map_canvas"></div>
		</section>	
	</div>
	
	<footer id="footer">
		Copyright &copy; 2013 WiselyThemes. All rights reserved.<br/>
		<div id="sn-icons">
			<a href=""><i class="icon-facebook-sign"></i><i class="icon-facebook-sign grey"></i></a>
			<a href=""><i class="icon-twitter-sign"></i><i class="icon-twitter-sign grey"></i></a>
			<a href=""><i class="icon-google-plus-sign"></i><i class="icon-google-plus-sign grey"></i></a>
			<a href=""><i class="icon-pinterest-sign"></i><i class="icon-pinterest-sign grey"></i></a>
			<a href=""><i class="icon-linkedin-sign"></i><i class="icon-linkedin-sign grey"></i></a>
			<a href=""><i class="icon-youtube-sign"></i><i class="icon-youtube-sign grey"></i></a>
			<a href=""><i class="icon-rss-sign"></i><i class="icon-rss-sign grey"></i></a>
		</div>
	</footer>
	
	<!-- BEGIN SINGLE PORTFOLIO ITEM TEMPLATE -->
	<div class="project-page">
		<header class="project-header">
			<button class="btn white2 portfolio-back">Back <i class="icon-arrow-right"></i></button>
			<<?=Util::baseUrl('public/images').'/';?> src="<?=Util::baseUrl('public/images').'/';?>/portfolio/mochito_bg_portfolio_header.jpg" alt="" id="project-header-bg" />
			<div class="container">
				<div class="row">
					<div class="col-sm-8 project-desc"></div>
				</div>
			</div>
		</header>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 project-overview"></div>
			</div>
		</div>
		<button class="btn portfolio-back">Back <i class="icon-arrow-right"></i></button>
	</div>
	<!-- END SINGLE PORTFOLIO ITEM TEMPLATE -->
	
	<!-- BEGIN TEMPLATE SETTINGS PANEL -->
	<div id="template-settings">
		<i class="icon-cog"></i>
		
		<h4>THEME:</h4>
		<select name="theme">
			<option value="lighttheme">Light Theme</option>
			<option value="darktheme">Dark Theme</option>
		</select>
		
		<h4>COLOR: *</h4>
		<input class="minicolors" type="text" name="color-picker" value="404d75" />
		
		<h4>PATTERN:</h4>
		<h4>Dark</h4>
		<div class="settings-pattern">
			<span class="pattern_icon1_black_white" id="pattern1_black"></span>		
			<span class="pattern_icon2_black_white" id="pattern2_black"></span>
			<span class="pattern_icon3_black_white" id="pattern3_black"></span>
			<span class="pattern_icon4_black_white" id="pattern4_black"></span>
			<span class="pattern_icon5_black_white" id="pattern5_black"></span>
			<span class="pattern_icon6_black_white" id="pattern6_black"></span>
			<span class="pattern_icon7_black_white" id="pattern7_black"></span>
			<span class="pattern_icon8_black_white" id="pattern8_black"></span>
			<span class="pattern_icon9_black_white selected" id="pattern9_black"></span>
			<span class="pattern_icon10_black_white" id="pattern10_black"></span>
			<span class="pattern_icon11_black_white" id="pattern11_black"></span>
			<span class="pattern_icon12_black_white" id="pattern12_black"></span>
			<span class="pattern_icon13_black_white" id="pattern13_black"></span>
			<span class="pattern_icon14_black_white" id="pattern14_black"></span>
			<span class="pattern_icon15_black_white" id="pattern15_black"></span>
			<span class="pattern_icon16_black_white" id="pattern16_black"></span>
		</div>
		
		<h4>Light</h4>
		<div class="settings-pattern">
			<span class="pattern_icon1_white_white" id="pattern1_white"></span>		
			<span class="pattern_icon2_white_white" id="pattern2_white"></span>
			<span class="pattern_icon3_white_white" id="pattern3_white"></span>
			<span class="pattern_icon4_white_white" id="pattern4_white"></span>
			<span class="pattern_icon5_white_white" id="pattern5_white"></span>
			<span class="pattern_icon6_white_white" id="pattern6_white"></span>
			<span class="pattern_icon7_white_white" id="pattern7_white"></span>
			<span class="pattern_icon8_white_white" id="pattern8_white"></span>
			<span class="pattern_icon9_white_white" id="pattern9_white"></span>
			<span class="pattern_icon10_white_white" id="pattern10_white"></span>
			<span class="pattern_icon11_white_white" id="pattern11_white"></span>
			<span class="pattern_icon12_white_white" id="pattern12_white"></span>
			<span class="pattern_icon13_white_white" id="pattern13_white"></span>
			<span class="pattern_icon14_white_white" id="pattern14_white"></span>
			<span class="pattern_icon15_white_white" id="pattern15_white"></span>
			<span class="pattern_icon16_white_white" id="pattern16_white"></span>
		</div>
		
		<div>* May not be fully accurate!</div>
	</div>
	<!-- END TEMPLATE SETTINGS PANEL -->
	
	
	<!-- Libs -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?=Util::js('jquery-1.9.1.min.js');?>"><\/script>')</script>
	<script src="<?=Util::js('');?>jquery.easing.min.js"></script>
	
	<script src="<?=Util::js('bootstrap.min.js');?>"></script>
	<script src="<?=Util::js('jquery.scrollTo-1.4.2-min.js');?>"></script>
	<script src="<?=Util::js('jquery.placeholder.min.js');?>"></script>
	<script src="<?=Util::js('waypoints.min.js');?>"></script>
	<script src="<?=Util::js('waypoints-sticky.min.js');?>"></script>
	<script src="<?=Util::js('retina.js');?>"></script>
	<script src="<?=Util::js('jquery.parallax-1.1.3.js');?>"></script>
	<script src="<?=Util::js('jquery.imagesloaded.js');?>"></script>
	<script src="<?=Util::js('jquery.wookmark.min.js');?>"></script>
	<script src="<?=Util::js('portfolioanimation.js');?>"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="<?=Util::js('jquery.minicolors.js');?>"></script>
	<script src="<?=Util::js('template.settings.js');?>"></script>
	<script src="<?=Util::js('hoverIntent.js');?>"></script>
	<script src="<?=Util::js('superfish.js');?>"></script>
	<script src="<?=Util::js('scripts.js');?>"></script>
	
	<script type="text/javascript">
		//<![CDATA[
		Mochito.initialize(40.73347, -73.993607, 'Mochito', '<br/>24th Street<br/>New York, USA<br/><br/>Tel.: 555 123 456 789<br/>Fax: 555 123 456 780', '<?=Util::baseUrl('public/images').'/';?>/logo.png');
		//]]>
		
		//Initialize Superfish menu
		$(document).ready(function(){
			$('.sf-menu').superfish();
		});
    </script>

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src='//www.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>