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
  // echo '<pre>';
  // echo var_dump($t_object);
  // echo '</pre>';

?>
<article class="object">
  <a class="link link--back" href="">Back to search results</a>

  <!-- what if there are multiple images? generate/style carousel?? -->
  <!-- if image --> 

  <div class="object-images">
    <figure class="object-image">
      <img src="" alt="" width="1200" height="800">
      <figcaption class="object-image-caption">Image caption</figcaption>
      <button class="button button--catalogue">Download image</button>
    </figure>
    <!-- other images in gallery? -->
    <div class="object-images-gallery">
      <img src="" alt="" width="120" height="80">
      <img src="" alt="" width="120" height="80">
    </div>
  </div>
  <!-- endif image -->
  <div class="object-details">
    <div class="object-details-intro">
      <span class="object-label record-type">Object</span>
      <h1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</h1>
      <dl class="object-detail-list">
        {{{<ifcount code="ca_entities" min="1" max="1"><dt>Artist/Creator:</dt></ifcount>}}}
        {{{<ifcount code="ca_entities" min="2"><dt>Artists/Creators</dt></ifcount>}}}
        <dd>
          {{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
        </dd>
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><dt>Date:</dt><dd>^ca_objects.dateSet.setDisplayValue</dd></ifdef>}}}

        <!-- <dt>Date:</dt>
        <dd></dd> -->
        <!-- Is idno the Object Number? -->
				{{{<ifdef code="ca_objects.idno"><dt>Object Number:</dt><dd>^ca_objects.idno<dd/></ifdef>}}}

        <!-- <dt>Object number:</dt>
        <dd></dd> -->
      </dl>
    </div>
    <div class="object-details-box bordered accordion">
      <div class="object-details-box-header">
        <h2>Physical Description</h2>
        <button class="button accordion-toggle">Hide</button>
      </div>
      <dl class="object-detail-list accordion-details" aria-expanded="true">
      <!-- Is description different than phyiscal extent?? -->
        {{{<ifdef code="ca_objects.description">
					<dt class='unit'>Description</dt>
          <dd class="trimText">^ca_objects.description</dd>
				</ifdef>}}}
        <dt>Physical extent:</dt>
        <dd>Example with longer text that will go to the second line</dd>
        <dt>Object type:</dt>
        <dd>{{{<unit>^ca_objects.type_id</unit>}}}</dd>
        <!-- <dt>Medium:</dt>
        <dd>example</dd>         -->
        <!-- <dt>Duration:</dt>
        <dd>example</dd> -->
        <!-- Measurements? test this -->
				<!-- {{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}} -->
        <!-- <dt>Dimensions:</dt>
        <dd>example</dd> -->
      </dl>
    </div>
    <div class="object-details-box bordered accordion">
      <div class="object-details-box-header">
        <h2>Collection History</h2>
        <button class="button accordion-toggle">Hide</button>
      </div>
      <dl class="object-detail-list accordion-details" aria-expanded="true">
      <!-- Can you loop through these and only show ones that have values? -->
        <dt>Collection:</dt>
        <dd></dd>
        <dt>Provenance:</dt>
        <dd></dd>
        <dt>Exhibition History:</dt>
        <dd></dd>        
      </dl>
    </div>
    <div class="object-actions">
      <button class="button button--catalogue ">Export</button>
      <button class="button button--catalogue ">Contact us</button>
      <button class="button button--catalogue ">Share</button>
    </div>
  </div>
</article>