<!doctype html>
	<head>
		<meta charset="utf-8">
		<title><?php print_title(); ?></title>
		<link rel="shortcut icon" href="<?php echo THEMEPATH; ?>images/favicon.ico">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="cleartype" content="on">
		<?php wp_head(); ?>
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script src="//use.typekit.net/wqp7onq.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
		<!-- Hotjar Tracking Code for www.fotografica.mx -->
		<script>
		    (function(h,o,t,j,a,r){
		        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		        h._hjSettings={hjid:23204,hjsv:5};
		        a=o.getElementsByTagName('head')[0];
		        r=o.createElement('script');r.async=1;
		        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		        a.appendChild(r);
		    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
		


	</head>

	<body <?php body_class(); ?>>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MS3M6X"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MS3M6X');</script>
		<!-- End Google Tag Manager -->

		<script>(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		_fbq.push(['addPixelId', '1133837239976877']);
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', 'PixelInitialized', {}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1133837239976877&amp;ev=PixelInitialized" /></noscript>

		<script>
			var fbApiInit = false;
			var testId = '853048764736608';
			var prodId = '852965808078237';
			window.fbAsyncInit = function() {
				FB.init({
					appId      : prodId,
					xfbml      : true,
					version    : 'v2.2'
				});
				fbApiInit = true;
			};

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>

		<!--[if lt IE 9]>
			<p class="chromeframe">Estás usando una versión <strong>vieja</strong> de tu explorador. Por favor <a href="http://browsehappy.com/" target="_blank"> actualiza tu explorador</a> para tener una experiencia completa.</p>
		<![endif]-->
		<div class="[ container ]">
			<!-- Push Wrapper -->
			<div id="mp-pusher" class="[ mp-pusher ]">
				<!-- mp-menu -->
				<nav id="mp-menu" class="[ mp-menu ]">
					<div class="[ mp-level ]">
						<h2 class="[ text-center uppercase ]">Menú</h2>
						<ul class="[ overflow-scroll ]">
							<li>
								<a class="[ text-center uppercase ]" href="#">Colecciones</a>
								<div class="[ mp-level ]">
									<h2 class="[ text-center uppercase ]">Colecciones</h2>
									<a class="[ mp-back ][ text-center uppercase ]" href="#">atrás</a>
									<ul class="[ overflow-scroll ]">
										<?php

											$args = array(
											    'orderby'		=> 'slug',
											    'order'         => 'ASC',
											    'hide_empty'    => true,
											    'parent'		=> 0,
											);
											$terms = get_terms('coleccion', $args);
											foreach ($terms as $key => $term) {
												// Does the current term have any children?
												$term_children = get_term_children( $term->term_id, 'coleccion');
												if( empty($term_children) ) {
										?>
													<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?coleccion='.$term->slug ?>"><?php echo $term->name ?></a></li>
										<?php
													continue;
												}
										?>
												<li>
													<a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?coleccion='.$term->slug ?>"><?php echo $term->name ?></a>
													<div class="[ mp-level ]">
														<h2 class="[ text-center uppercase ]"><?php echo $term->name ?></h2>
														<a class="[ mp-back ][ text-center uppercase ]" href="#">atrás</a>
														<ul>
										<?php
														foreach ($term_children as $key => $child) {
															$child_term = get_term_by('id', $child, 'coleccion');
															echo '<li><a class="[ text-center uppercase ]" href="'.site_url().'/colecciones?coleccion='.$child_term->slug.'">'.$child_term->name.'</a></li>';
														}
										?>
														</ul>
													</div>
												</li>
										<?php
											}// foreach term
										?>
										<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?coleccion=adquisiciones-recientes' ?>">Adquisiciones recientes</a></li>
										<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?filtro=favoritos' ?>">Favoritos</a></li>
									</ul>
								</div>
							</li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/fotografos'?>">Fotógrafos</a></li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/proyecto'?>">Proyectos</a></li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/exposiciones'?>">Exposiciones</a></li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/publicaciones'?>">Publicaciones</a></li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/cartelera'?>">Cartelera</a></li>
							<li>
								<a class="[ text-center uppercase ]" href="#">Nuestro trabajo</a>
								<div class="[ mp-level ]">
									<h2 class="[ text-center uppercase ]">Nuestro trabajo</h2>
									<a class="[ mp-back ][ text-center uppercase ]" href="#">atrás</a>
									<ul class="[ overflow-scroll ]">
										<li>
											<a class="[ text-center uppercase ]" href="<?php echo site_url().'/nuestro-trabajo/conocenos'?>">Conócenos</a>
										</li>
										<li>
											<a class="[ text-center uppercase ]" href="<?php echo site_url().'/nuestro-trabajo/investigacion'?>">Investigación</a>
										</li>
										<li>
											<a class="[ text-center uppercase ]" href="<?php echo site_url().'/nuestro-trabajo/conservacion'?>">Conservación</a>
										</li>
									</ul>
								</div>
							</li>
							<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/contactanos' ?>">Contáctanos</a></li>
						</ul>
					</div>
				</nav><!-- /mp-menu -->
				<div class="[ content-wrapper ]"><!-- this is for emulating position fixed of the nav -->
					<div class="[ content ]">
						<div class="[ header-wrapper ]">
							<header class="[ ]">
								<div class="[ wrapper ][ hidden--large ]">
									<nav class="[ row ]">
										<div class="[ columna xmall-2 ]">
											<a id="trigger-xmall" class="[ inline-block ][ menu-trigger ][ menu__item ]" href="#">
												<i class="[ icon-menu ][ bg-highlight color-claro ]"></i>
											</a>
										</div>
										<div class="[ columna xmall-8 ][ text-center ]">
											<h1 class="[ text-center ]">
												<a class="[ inline-block ][ menu__item menu__item-large ]" href="<?php echo site_url(); ?>">
													<?php
														switch ( is_home() ) {
															case true:
																echo '<i class="[ icon-logo-fotografica ]"></i>';
																break;
															default:
																echo '<i class="[ icon-logo-fotografica-chico ]"></i>';
																break;
														}
													?>
												</a>
											</h1>
										</div>
										<div class="[ columna xmall-2 ][ text-right ]">
											<a class="[ inline-block ][ menu__item menu__item-medium ]" href="http://www.fundaciontelevisa.org/" target="_blank">
												<i class="[ icon-logo-fundacion-televisa ]"></i>
											</a>
										</div>
									</nav>
								</div><!-- [ hidden-large ] -->
								<div class="[ wrapper ][ shown--large ]">
									<nav class="[ row ]">
										<div class="[ columna xmall-4 ][ text-left ]">
											<a id="trigger-medium" class="[ inline-block ][ menu-trigger ][ menu__item ]" href="#">
												<i class="[ icon-menu ][ bg-highlight color-claro ]"></i>
											</a>
										</div>
										<div class="[ columna xmall-4 ]">
											<h1 class="[ text-center ]">
												<a class="[ inline-block ][ menu__item menu__item-large ]" href="<?php echo site_url(); ?>">
													<?php
														switch ( is_home() ) {
															case true:
																echo '<i class="[ icon-logo-fotografica ]"></i>';
																break;
															default:
																echo '<i class="[ icon-logo-fotografica-chico ]"></i>';
																break;
														}
													?>
												</a>
											</h1>
										</div>
										<div class="[ columna xmall-4 ][ relative ][ text-right ]">
											<div id="sb-search" class="[ sb-search ][ inline-block align-middle ]">
												<form id="forma_busqeda" class="forma_busqeda" method="get" action="<?php echo site_url(); ?>">
													<input class="sb-search-input" placeholder="¿Qué quieres buscar?" type="text" name="s" id="s">
													<input class="sb-search-submit" type="submit" value="">
													<button class="[ sb-icon-search ][ inline-block align-middle ][ menu__item menu__item-small ]">
														<i class="[ icon-search ][ bg-highlight color-claro ]"></i>
													</button>
												</form>
											</div><a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="https://vimeo.com/fotograficamx" target="_blank">
												<i class="[ icon-vimeo ]"></i>
											</a><a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="https://twitter.com/FotograficaMx" target="_blank">
												<i class="[ icon-twitter ]"></i>
											</a><a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="https://www.facebook.com/FOTOGRAFICA.FundacionTelevisa" target="_blank">
												<i class="[ icon-facebook ]"></i>
											</a><a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="http://i.instagram.com/fotograficamx/" target="_blank">
												<i class="[ icon-instagram ]"></i>
											</a><a class="[ inline-block align-middle ][ menu__item menu__item-large ]" href="http://www.fundaciontelevisa.org/" target="_blank">
												<i class="[ icon-logo-fundacion-televisa ]"></i>
											</a>
										</div>
									</nav>
								</div><!-- [ shown-large ] -->
							</header>
						</div>
						<div class="[ main-wrapper ][ margin-bottom ]" >
							<div class="[ main ]">