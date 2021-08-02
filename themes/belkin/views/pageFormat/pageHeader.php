<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
	// $va_lightboxDisplayName = caGetLightboxDisplayName();
	// $vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	// $va_classroomDisplayName = caGetClassroomDisplayName();
	// $vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	// # Collect the user links: they are output twice, once for toggle menu and once for nav
	// $va_user_links = array();
	// if($this->request->isLoggedIn()){
	// 	$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
	// 	$va_user_links[] = '<li class="divider nav-divider"></li>';
	// 	if(caDisplayLightbox($this->request)){
	// 		$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
	// 	}
	// 	if(caDisplayClassroom($this->request)){
	// 		$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
	// 	}
	// 	$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		
	// 	if ($this->request->config->get('use_submission_interface')) {
	// 		$va_user_links[] = "<li>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
	// 	}
	// 	$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	// } else {	
	// 	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
	// 	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	// }
	// $vb_has_user_links = (sizeof($va_user_links) > 0);


?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>

	<!-- <?php print AssetLoadManager::getLoadHTML($this->request); ?> -->

  <!-- This is what AssetLoadManager was bringing in... -->
  <script src="/pawtucket/assets/jquery/js/jquery.min.js" type="text/javascript"></script>
  <!-- <link rel="stylesheet" href="/pawtucket/assets/bootstrap/css/bootstrap.css" type="text/css" media="all"> -->
  <script src="/pawtucket/assets/bootstrap/js/bootstrap.js" type="text/javascript"></script>
  <!-- <link rel="stylesheet" href="/pawtucket/assets/bootstrap/css/bootstrap-theme.css" type="text/css" media="all"> -->
  <script src="/pawtucket/assets/jquery/js/jquery-migrate-3.0.1.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/circular-slider/circular-slider.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/jquery/circular-slider/circular-slider.css" type="text/css" media="all">
  <script src="/pawtucket/assets/jquery/js/threesixty.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/fontawesome/css/font-awesome.min.css" type="text/css" media="all">
  <script src="/pawtucket/assets/pdfjs/pdf.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/pdfjs/viewer/viewer.css" type="text/css" media="all">
  <script src="/pawtucket/assets/jquery/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/js/jquery.cookiejar.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/js/jquery.jscroll.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/js/jquery.hscroll.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/js/jquery.jscrollpane.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/jquery/js/jquery.jscrollpane.css" type="text/css" media="all">
  <script src="/pawtucket/assets/ca/js/ca.utils.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/jquery/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/jquery/jquery-ui/jquery-ui.min.css" type="text/css" media="all">
  <link rel="stylesheet" href="/pawtucket/assets/jquery/jquery-ui/jquery-ui.structure.min.css" type="text/css" media="all">
  <link rel="stylesheet" href="/pawtucket/assets/jquery/jquery-ui/jquery-ui.theme.min.css" type="text/css" media="all">
  <script src="/pawtucket/assets/ca/js/ca.genericpanel.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/videojs/video.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/videojs/video-js.css" type="text/css" media="all">
  <script src="/pawtucket/assets/mediaelement/mediaelement-and-player.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/mediaelement/mediaelementplayer.min.css" type="text/css" media="all">
  <script src="/pawtucket/assets/jquery/js/jquery.mousewheel.js" type="text/javascript"></script>
  <script src="/pawtucket/assets/chartist/dist/chartist.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/chartist/dist/chartist.min.css" type="text/css" media="all">
  <script src="/pawtucket/assets/jquery/js/jquery.jCarousel.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/pawtucket/assets/jquery/js/jquery.jCarousel.css" type="text/css" media="all">

  <script src="/pawtucket/themes/belkin/assets/pawtucket/css/theme.js"></script>
  <link rel="stylesheet" href="/pawtucket/themes/belkin/assets/pawtucket/css/belkin-import.css" type="text/css" media="all">
  <link rel="stylesheet" href="/pawtucket/themes/belkin/assets/pawtucket/css/theme.css">

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body>
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<header class="navbar navbar-default yamm" role="navigation">
    <nav class="main-nav">
      <ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
        <li><a class="link link--back" href="https://belkin.ubc.ca/">Back To Gallery</a></li>  
        <li><a href="/pawtucket">Collections Home</a></li>
        <li><a href="https://belkin.ubc.ca/collections/">About the Collections</a></li>
        <li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact Us"), "", "", "Contact", "Form"); ?></li>
      </ul>
    </nav>
    <div class="name"><a href="https://belkin.ubc.ca/">Morris and Helen <strong>Belkin Art Gallery</strong></a></div>
  </header>
  <main id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
