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
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script src="//use.typekit.net/wqp7onq.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
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
										<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?filtro=nuevas-adquisiciones' ?>">Nuevas adquisiciones</a></li>
										<li><a class="[ text-center uppercase ]" href="<?php echo site_url().'/colecciones?filtro=favoritos' ?>">Favoritos</a></li>
										<?php
											$args = array(
											    'orderby'		=> 'name',
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
															echo '<li><a class="[ text-center uppercase ]" href="#">'.$child_term->name.'</a></li>';
														}
										?>
														</ul>
													</div>
												</li>
										<?php
											}// foreach term
										?>
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
													<i class="[ icon-logo-fotografica ]"></i>
												</a>
											</h1>
										</div>
										<div class="[ columna xmall-2 ][ text-right ]">
											<!-- <a class="[ inline-block ][ menu__item menu__item-large ]" href="http://www.fundaciontelevisa.org/" target="_blank">
												<i class="[ icon-logo-fundacion-televisa ]"></i>
											</a> -->
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
													<i class="[ icon-logo-fotografica ]"></i>
												</a>
											</h1>
										</div>
										<div class="[ columna xmall-4 ][ ][ text-right ]">
											<a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="#">
												<i class="[ icon-search ][ bg-highlight color-claro ]"></i>
											</a>
											<a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="https://twitter.com/FotograficaMx">
												<i class="[ icon-twitter ]"></i>
											</a>
											<a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="https://www.facebook.com/FOTOGRAFICA.FundacionTelevisa">
												<i class="[ icon-facebook ]"></i>
											</a>
											<a class="[ inline-block align-middle ][ menu__item menu__item-small ]" href="http://i.instagram.com/fotograficamx/">
												<i class="[ icon-instagram ]"></i>
											</a>
											<a class="[ inline-block align-middle ][ menu__item menu__item-large ]" href="http://www.fundaciontelevisa.org/" target="_blank">
												<i class="[ icon-logo-fundacion-televisa ]"></i>
											</a>
										</div>
									</nav>
								</div><!-- [ shown-large ] -->
							</header>
						</div>
						<div class="[ main-wrapper ][ margin-bottom ]" >
							<div class="[ main ]">