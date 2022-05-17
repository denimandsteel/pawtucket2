<?php
	$t_item = $this->getVar("item");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
  $current_id = $t_item->get('ca_collections.collection_id');

  $web_notice = $t_item->get("ca_collections.web_notice");
  $artist = ($t_item->get('ca_entities.preferred_labels.displayname'));
?>
<article class="detail">
  <nav class="detail-nav container">
    <div class="detail-breadcrumb">
      {{{<ifdef code="ca_collections.parent_id"><div class="unit"><unit relativeTo="ca_collections.hierarchy" delimiter=" / "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
    </div>
  </nav>

  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
        {{{<h1>^ca_collections.preferred_labels.name</h1>}}}

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

            <dt>ID #</dt>
            {{{<ifdef code="ca_collections.idno"><dd> ^ca_collections.idno </dd></ifdef>}}}
            {{{<ifnotdef code="ca_collections.idno"><dd>–</dd></ifnotdef>}}}

            {{{<ifdef code="ca_collections.web_notice">
            <dt>Notice</dt>
              <dd>^ca_collections.web_notice</dd>
            </ifdef>}}}

            {{{<ifdef code="ca_collections.content_notice">
            <dt>Content Notice</dt>
              <dd>^ca_collections.content_notice</dd>
            </ifdef>}}}

            <dt>Date</dt>
            {{{<ifdef code="ca_collections.pub_date">
              <unit delimiter="<br>"><dd>^ca_collections.pub_date</dd></unit>
            </ifdef>
            <ifnotdef code="ca_collections.pub_date">
              <dd>–</dd>
            </ifnotdef>}}} 

            <dt>Level of Description</dt>
            {{{<ifdef code="ca_collections.level_description">
              <dd>^ca_collections.level_description</dd>
            </ifdef>
            <ifnotdef code="ca_collections.level_description">
              <dd>–</dd>
            </ifnotdef>}}} 
      
          </dl>
        </div>
      </div>
    </div>
        
    {{{<ifdef code="ca_collections.RAD_scopecontent">
    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Scope & Content</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
					 <p class='unit detail-info-paragraph'>^ca_collections.RAD_scopecontent</p>
        </div>
      </div>
    </div>
    </ifdef>}}}

    <div class="detail-info-box fw-border-top accordion <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Physical Description</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">
        <!-- Is description different than phyiscal extent?? -->
          <dt>Physical Extent</dt>
          {{{<ifdef code="ca_collections.RAD_extent">
            <dd><unit delimiter="<br>">^ca_collections.RAD_extent</unit></dd>
          </ifdef>
          <ifnotdef code="ca_collections.RAD_extent">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Material Type</dt>
          {{{<ifdef code="ca_collections.gmd">
            <dd><unit delimiter=", ">^ca_collections.gmd</unit></dd>
          </ifdef>
          <ifnotdef code="ca_collections.gmd">
            <dd>–</dd>
          </ifnotdef>}}} 

        </dl>
      </div>
    </div>

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
                $('#hierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $vn_top_level_collection_id, 'current_id' => $current_id ), array('useQueryString' => true)); ?>", undefined, function(){
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
    
    <div class="detail-actions fw-border-top <?php if ($web_notice) { echo 'hidden-from-notice'; } ?>">
      <div class="container">
        <p class='detail-actions-paragraph'>Descriptions are works in progress and may be updated as new descriptive practices, research and information emerge. To help improve this record, please contact us.</p>
        <?php print caNavLink($this->request, _t("Contact Us"), "button button--catalogue", "", "Contact", "Form"); ?>
      </div>
    </div>
</article>
