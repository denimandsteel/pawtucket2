<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-8">
			<H1>Welcome to the Girl Scouts of the USA Collections</H1>
			<p>
				The collection of the Girl Scouts of the USA documents the history of the world’s largest female-led global organization for girls. Primarily highlighting the role of American girls and women from its inception in 1912, the collection includes corporate records, ephemera, media, scrapbooks, fine and decorative arts, furnishings, textiles, sculpture, jewelry, silver, international gifts, product and memorabilia, awards and recognitions, Girl Scout uniforms, badges, and insignia, and other pieces that span centuries, nations, and styles.
			</p>
			<p>
				A wide variety of artists, craftspeople, and manufacturers are represented, including Tiffany, Cartier, Alfred Jonniaux, W. & J. Sloane, and George Peter Alexander Healy, to name a select few, as well as letters and other papers of Juliette Gordon Low, the founder, and Lou Henry Hoover, wife of President Herbert Hoover and twice National President of Girl Scouts, amongst others.
			</p>
			<p>
				The collections are housed in the Girl Scouts of the USA National Headquarters in New York City, the Edith Macy Conference Center in Briarcliff Manor, New York, and the Juliette Gordon Low Birthplace in Savannah, Georgia.
			</p>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
