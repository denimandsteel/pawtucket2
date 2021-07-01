<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');

?>
<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb">{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> / </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</div>
  </nav>
  <!-- what if there are multiple images? generate/style carousel?? -->
  <!-- if image --> 

  <div class="detail-images">
    <div class="container">
      <!-- <div class="detail-image-grid">
        <figure class="detail-image">
          <img src="" alt="" width="1200" height="800">
          <figcaption class="detail-image-caption">Image caption</figcaption>
          <a class="link">Request this image</a>
        </figure> -->
        <!-- other images in gallery? -->
        <!-- <div class="detail-images-gallery">
          <img src="" alt="" width="120" height="80">
          <img src="" alt="" width="120" height="80">
        </div>
      </div> -->
      {{{representationViewer}}}						
				<div id="detailAnnotations"></div>			
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
    </div>
  </div>
  <!-- endif image -->

  <div class="detail-info">
    <div class="detail-info-intro fw-border-top">
      <div class="container">
        <span class="detail-label">Object</span>
        {{{<ifdef code="ca_objects.preferred_labels.name">
            <h1>^ca_objects.preferred_labels.name</h1>
        </ifdef>}}}
        <dl class="detail-info-list">
          {{{<ifcount restrictToRelationshipTypes="creator" code="ca_entities" min="1" max="1"><dt>Artist/Creator:</dt></ifcount>}}}
          {{{<ifcount restrictToRelationshipTypes="creator" code="ca_entities" min="2"><dt>Artists/Creators:</dt></ifcount>}}}

          {{{<unit restrictToRelationshipTypes="creator" relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit restrictToRelationshipTypes="creator" relativeTo="ca_entities"><l>
            <dd>^ca_entities.preferred_labels</dd>
          </l>}}}


          {{{<ifdef code="ca_objects.pub_date">
            <dt>Date:</dt>
            <dd>^ca_objects.pub_date</dd>
          </ifdef>}}} 


          {{{<ifdef code="ca_objects.idno">
            <dt>Object Number:</dt>
            <dd>^ca_objects.idno</dd>
          </ifdef>}}}
        </dl>
      </div>
    </div>

    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Physical Description</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">
        <!-- Is description different than phyiscal extent?? -->
          {{{<ifdef code="ca_objects.description">
            <dt class='unit'>Description</dt>
            <dd class="trimText">^ca_objects.description</dd>
          </ifdef>}}}
          {{{<ifdef code="ca_objects.custom_extent">
            <dt>Physical Extent:</dt>
            <dd>^ca_objects.custom_extent</dd>
          </ifdef>}}}
          {{{<ifdef code="ca_objects.artwork_object">
            <dt>Object type:</dt>
            <dd>^ca_objects.artwork_object</dd>
          </ifdef>}}}
          {{{<ifdef code="ca_objects.medium">
            <dt>Medium:</dt>
            <dd>^ca_objects.medium</dd>
          </ifdef>}}}
          {{{<ifdef code="ca_objects.duration">
            <dt>Duration:</dt>
            <dd>^ca_objects.duration</dd>
          </ifdef>}}}
        </dl>
      </div>
    </div>
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Collection History</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">
          <dt>Collection</dt>
          {{{<unit relativeTo="ca_collections" delimiter="<br/>"><l><dd>^ca_collections.preferred_labels.name</dd></l></unit>}}}
          <dt>Related Exhibitions</dt>
          {{{<unit relativeTo="ca_occurences" delimiter="<br/>"><l><dd>^ca_occurences.preferred_labels.name</dd></l></unit>}}}
          <dd></dd>
        </dl>
      </div>
      </div>
    </div>
    <!-- <div class="detail-actions fw-border-top">
      <div class="container">
        <button class="button button--catalogue ">Export</button>
        <button class="button button--catalogue ">Contact us</button>
        <button class="button button--catalogue ">Share</button>
      </div>
    </div> -->
</article>