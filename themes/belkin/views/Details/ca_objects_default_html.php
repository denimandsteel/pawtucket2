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

	$t_item = $this->getVar("item");
  $vn_top_level_collection_id = $t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true))[0];

?>
<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb">{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> / </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</div>
  </nav>

  <div class="detail-images">
    <div class="container">
      {{{representationViewer}}}						
				<div id="detailAnnotations"></div>			
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>		
    </div>
  </div>
  <!-- endif image -->

  <div class="detail-info">
    <div class="detail-info-intro fw-border-top">
      <div class="container">
        {{{<ifdef code="ca_objects.catalogue_destination">
            <span class="detail-label">^ca_objects.catalogue_destination.preferred_labels</span>
        </ifdef>}}}
        {{{<ifdef code="ca_objects.preferred_labels.name">
            <h1>^ca_objects.preferred_labels.name</h1>
        </ifdef>}}}
        <dl class="detail-info-list">
          {{{<ifcount restrictToRelationshipTypes="creator, artist" code="ca_entities" min="1" max="1"><dt>Artist/Creator</dt></ifcount>}}}
          {{{<ifcount restrictToRelationshipTypes="creator, artist" code="ca_entities" min="2"><dt>Artists/Creators</dt></ifcount>}}}

          {{{<unit restrictToRelationshipTypes="creator, artist" relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit restrictToRelationshipTypes="creator, artist" relativeTo="ca_entities"><l>
            <dd>^ca_entities.preferred_labels</dd>
          </l>}}}

          <dt>Date</dt>
          {{{<ifdef code="ca_objects.search_date">
            <dd>^ca_objects.search_date</dd>
          </ifdef>
          <ifnotdef code="ca_objects.search_date">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>ID #</dt>
          {{{<ifdef code="ca_objects.idno">
            <dd>^ca_objects.idno</dd>
          </ifdef>
          <ifnotdef code="ca_objects.idno">
            <dd>–</dd>
          </ifnotdef>}}}
            
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
          <dt>Medium</dt>
          {{{<ifdef code="ca_objects.medium">
            <dd><unit delimiter=", ">^ca_objects.medium</unit></dd>
          </ifdef>
          <ifnotdef code="ca_objects.medium">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Support</dt>
          {{{<ifdef code="ca_objects.support">
            <dd>^ca_objects.support</dd>
          </ifdef>
          <ifnotdef code="ca_objects.support">
            <dd>–</dd>
          </ifnotdef>}}} 

          <!-- ONLY FOR ARTWORKS - add condition? -->
          <dt>Dimensions</dt>
          <dd>
            {{{<ifdef code="ca_objects.dimensions.height">h- ^ca_objects.dimensions.height</ifdef>
            <ifdef code="ca_objects.dimensions.width">w- ^ca_objects.dimensions.width</ifdef> 
            <ifdef code="ca_objects.dimensions.depth">d- ^ca_objects.dimensions.depth </ifdef>
            <ifdef code="ca_objects.dimensions.width|ca_objects.dimensions.height|ca_objects.dimensions.depth"> cm</ifdef>
            <ifnotdef code="ca_objects.dimensions.width|ca_objects.dimensions.height|ca_objects.dimensions.depth">–</ifnotdef>}}}
          </dd>

          {{{<ifdef code="ca_objects.duration">
          <dt>Duration</dt>
          <dd>^ca_objects.duration</dd>
          </ifdef>}}}

          <dt class='unit'>Object Description</dt>
          {{{<ifdef code="ca_objects.description">
            <dd class="trimText">^ca_objects.description</dd>
          </ifdef>
          <ifnotdef code="ca_objects.description">
            <dd>–</dd>
          </ifnotdef>}}}
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
          {{{
          <ifdef code="ca_collections">
            <unit relativeTo="ca_collections" delimiter="<br/>"><l><dd>^ca_collections.preferred_labels.name</dd></l></unit>
          </ifdef>
          <ifnotdef code="ca_collections"><dd>–</dd></ifnotdef>
        }}}

          <dt>Credit Line</dt>
          {{{<ifdef code="ca_objects.credit_line">
            <dd>^ca_objects.credit_line</dd>
          </ifdef>
          <ifnotdef code="ca_objects.credit_line">
            <dd>–</dd>
          </ifnotdef>}}}
  
          <dt>Related Exhibitions</dt>
          {{{
            <ifdef code="ca_occurences">
              <unit relativeTo="ca_occurences" delimiter="<br/>"><l><dd>^ca_occurences.preferred_labels.name</dd></l></unit>
            </ifdef>
            <ifnotdef code="ca_occurences"><dd>–</dd></ifnotdef>
          }}}

          <!-- TODO: figure out what this actually is -->
          <!-- <dt>Exhibition History</dt>
          {{{
            <ifdef code="^ca_occurences.preferred_labels.name"><unit relativeTo="ca_occurences" delimiter="<br/>"><l><dd>^ca_occurences.preferred_labels.name</dd></l></unit></ifdef>
            <ifnotdef code="^ca_occurences.preferred_labels.name"><dd>–</dd></ifnotdef>
          }}} -->
        </dl>
      </div>
    </div>
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Navigate Fonds</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
            <div id="hierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
            <script>
              $(document).ready(function(){
                $('#hierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $vn_top_level_collection_id )); ?>"); 
              })
            </script>
          </div>
      </div>
    </div>
  </div>
  <div class="detail-actions fw-border-top">
    <div class="container">
      <button class="button button--catalogue "><?php print caDetailLink($this->request, "Export Results", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary')); ?></button>
      <button class="button button--catalogue ">Contact us</button>
    </div>
  </div>
</article>