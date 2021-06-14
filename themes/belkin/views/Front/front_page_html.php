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
    // pull in single image??
		// print $this->render("Front/featured_set_slideshow_html.php");
?>
  <article class="frontpage">
    <h1>Catalogue Home</h1>
    <div class="frontpage-browse">
      <div class="frontpage-intro spaced-content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
        <a class="link link--arrow" href="/pawtucket/index.php/About/Index">More About the Catalogue</a>
      </div>
      <div class="frontpage-search spaced-content">
        <h2>Begin Your Search</h2>
        <form class="search-form" action="/pawtucket/index.php/Search/objects" method="post">
          <input class="search-input" name="search" type="text" placeholder="Type Here..."><button class="button button--search">Search</button>
        </form>
        <a class="link link--arrow" href="">Refine Your Search</a>
        <a class="link link--arrow" href="">Search Tips</a>
      </div>
    </div>
    <div class="frontpage-item-preview">
      <!-- Pull in random object from featured items -->
      <figure>
        <img src="" alt="" height="400" width="600">
        <figcaption>Title, Artist, Data, Item xxx</figcaption>
      </figure>
      <a class="link link--arrow" href="">View in Catalogue</a>
      <a class="link link--arrow" href="">All Featured Items</a>
    </div>
  </article>