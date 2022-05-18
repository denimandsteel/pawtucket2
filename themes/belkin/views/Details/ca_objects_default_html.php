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
  $vn_top_level_collection_id = $t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true))[0][0];

  $is_artwork = ($t_item->get('ca_objects.catalogue_destination') == "493");
  $is_archive = ($t_item->get('ca_objects.catalogue_destination') == "492");

  $artist = ($t_item->get('ca_entities.preferred_labels.displayname'));

  $web_notice = $t_object->get("ca_objects.web_notice");
?>
<article class="detail">
  <nav class="detail-nav container">
    <div class="detail-breadcrumb">{{{<unit relativeTo="ca_collections" delimiter=" / "><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> / </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</div>
  </nav>

  <div class="detail-images <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
    <div class="detail-images-container container">
      {{{representationViewer}}}						
				<div id="detailAnnotations"></div>			
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "list", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>		
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
        <?php 
        if ($web_notice) {
          print '<div class="web-notice"><div class="web-notice-content"><h2>Notice</h2><p>'. $web_notice.'</p><div class="buttons"><button id="webNoticeBack" class="button button--sensitive">Go Back</button><button id="webNoticeContinue" class="button button--sensitive">Continue</button></div></div></div>';
        }
        ?>
        <div class="<?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
          <dl class="detail-info-list">

            {{{<ifcount code="ca_entities" min="0" max="1"><dt>Artist/Creator</dt></ifcount>}}}
            {{{<ifcount code="ca_entities" min="2"><dt>Artists/Creators</dt></ifcount>}}}

            <?php
              if(isset($artist)):
            ?>
            {{{  
              <dd>
                <unit relativeTo="ca_entities" delimiter="<br/>">
                    <l>^ca_entities.preferred_labels.displayname (^relationship_typename)</l> 
                </unit>
              </dd>
            }}}
            <?php
              else:
            ?>
            {{{
              <dd>–</dd>
            }}}
            <?php 
              endif;
            ?>

            <dt>Date</dt>
            {{{<ifdef code="ca_objects.pub_date">
              <unit delimiter="<br>"><dd>^ca_objects.pub_date</dd></unit>
            </ifdef>
            <ifnotdef code="ca_objects.pub_date">
              <dd>–</dd>
            </ifnotdef>}}} 

            <dt>ID #</dt>
            {{{<ifdef code="ca_objects.idno">
              <dd>^ca_objects.idno</dd>
            </ifdef>
            <ifnotdef code="ca_objects.idno">
              <dd>–</dd>
            </ifnotdef>}}}

            <?php if($is_archive): ?>
              <dt>Level of Description</dt>
              <dd>Item</dd>
            <?php endif ?>


            {{{<ifdef code="ca_objects.web_notice">
            <dt>Notice</dt>
              <dd>
                <p>^ca_objects.web_notice</p>
                <button id="webNoticeHide" class="button button--sensitive">Hide Content</button>
              </dd>
            </ifdef>}}}

            {{{<ifdef code="ca_objects.content_notice">
            <dt>Content Notice</dt>
              <dd>
                <p>^ca_objects.content_notice</p>
              </dd>
            </ifdef>}}}
          </dl>
        </div>
      </div>
    </div>

    <?php if($is_archive): ?>
    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Object Description</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <div class="accordion-details" aria-expanded="true">
          {{{<p class='unit detail-info-paragraph'>^ca_objects.description</p>}}}
        </div>
      </div>
    </div>
    <?php endif ?>

    <?php if($is_archive || $is_artwork): ?>

    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Physical Description</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">
        <!-- Is description different than phyiscal extent?? -->

        <?php if($is_artwork): ?>

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

          
          <dt>Dimensions</dt>
          <dd class="lowercase">
            {{{
              <unit relativeTo="ca_objects.measurements_item" skipWhen='^ca_objects.measurements_item.displaycheck_dimensions_item = "No"' delimiter="<br>">
                <ifdef code="ca_objects.measurements_item.dimensions_height_item,ca_objects.measurements_item.displaycheck_dimensions_item"><span class="dimension">^ca_objects.measurements_item.dimensions_height_item</span></ifdef>
                <ifdef code="ca_objects.measurements_item.dimensions_width_item,ca_objects.measurements_item.displaycheck_dimensions_item"><span class="dimension">^ca_objects.measurements_item.dimensions_width_item</span></ifdef>
                <ifdef code="ca_objects.measurements_item.dimensions_depth_item,ca_objects.measurements_item.displaycheck_dimensions_item"><span class="dimension">^ca_objects.measurements_item.dimensions_depth_item</span></ifdef>
                <ifdef code="ca_objects.measurements_item.dimensions_type_item,ca_objects.measurements_item.displaycheck_dimensions_item">(^ca_objects.measurements_item.dimensions_type_item)</ifdef>
                <ifdef code="ca_objects.measurements_item.dimensions_notes_item,ca_objects.measurements_item.displaycheck_dimensions_item"></br><p>^ca_objects.measurements_item.dimensions_notes_item)</p></ifdef>
              </unit>
              <ifnotdef code="ca_objects.measurements_item.dimensions_depth_item,ca_objects.measurements_item.dimensions_width_item,ca_objects.measurements_item.dimensions_depth_item,ca_objects.measurements_item.dimensions_type_item,ca_objects.measurements_item.dimensions_note_item">–</ifnotdef>
          }}}
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

        <?php endif ?>

        <?php if($is_archive): ?>
        
          <dt>Physical Extent</dt>
          {{{<ifdef code="ca_objects.custom_extent">
            <dd><unit delimiter=", ">^ca_objects.custom_extent</unit></dd>
          </ifdef>
          <ifnotdef code="ca_objects.custom_extent">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Material Type</dt>
          {{{<ifdef code="ca_objects.gmd">
            <dd><unit delimiter=", ">^ca_objects.gmd</unit></dd>
          </ifdef>
          <ifnotdef code="ca_objects.gmd">
            <dd>–</dd>
          </ifnotdef>}}} 
        <?php endif ?>
        </dl>
      </div>
    </div>
    <?php endif ?>

    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>History</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">

          <dt>Collection</dt>
          {{{
          <dd>
            <ifdef code="ca_collections">
              <unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
            </ifdef>
            <ifnotdef code="ca_collections">–</ifnotdef>
          </dd>
          }}}

          <dt>Credit Line</dt>

          {{{
          <dd>
            <ifdef code="ca_objects.credit_line">^ca_objects.credit_line</ifdef>
            <ifnotdef code="ca_objects.credit_line">–</ifnotdef>
          </dd> 
         }}}
  
          <dt>Related Exhibitions</dt>
        {{{
          <dd>
            <ifdef code="ca_occurrences.preferred_labels.name"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></ifdef>
            <ifnotdef code="ca_occurrences.preferred_labels.name">–</ifnotdef>
          </dd>
          }}}
        </dl>
      </div>
    </div>

    <?php 
    if($vn_top_level_collection_id):
    ?>
    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Navigate Fonds</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
            <div id="hierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
            <script>
              $(document).ready(function(){
                $('#hierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $vn_top_level_collection_id, 'current_id' => $vn_id ), array('useQueryString' => true)); ?>", undefined, function(){
                  $hierarchy = $('#hierarchy');
                  $isEmpty = !$hierarchy.children().length;
                  if($isEmpty){
                    $hierarchy.closest('.detail-info-box').hide();
                  }
                }); 

              })
            </script>
          </div>
      </div>
    </div>
  </div>
  <?php endif ?>

  <div class="detail-actions fw-border-top <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
    <div class="container">
      <p class='detail-actions-paragraph'>Descriptions are works in progress and may be updated as new descriptive practices, research and information emerge. To help improve this record, please contact us.</p>
      <?php print caNavLink($this->request, _t("Contact Us"), "button button--catalogue", "", "Contact", "Form"); ?>
    </div>
  </div>
</article>
