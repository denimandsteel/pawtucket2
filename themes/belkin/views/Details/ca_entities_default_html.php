<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	



  $convertDate = function($date) {
      $datetime =  date_create_from_format("F j Y", $date);
      if($datetime){
        return $datetime->format("j F Y");
      }
      else {
        return $date;
      }
      
  };

  $alternateNames = explode(';', $t_item->get("ca_entities.nonpreferred_labels.displayname"));
  $alternateNamesDisplay = explode(';', $t_item->get("ca_entities.nonpreferred_labels.type_id"));

  $vitalDateTypes = explode(';',$t_item->get('ca_entities.vital_dates_ind.ind_date_types'));
  $vitalDates = array_map($convertDate, explode(';', $t_item->get('ca_entities.vital_dates_ind.vital_date_ind')));
  
  $dateObjArray = [];
  for ($i = 0; $i < count($vitalDates); $i++) {
    // 954 - born
    // 956 - died
    if($vitalDateTypes[$i] == '954' || $vitalDateTypes[$i] == '956'){
      $dateObjArray[$i] = (object) [
        'date_type' => ($vitalDateTypes[$i] == 954) ? 'Born' : 'Died',
        'date' => $vitalDates[$i]
      ];
    }
  }

?>
<article class="detail">
  <nav class="detail-nav container">
    <div class="detail-breadcrumb">Artist/Creator</div>
  </nav>


  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
        {{{<h1>^ca_entities.preferred_labels.displayname</h1>}}}
        <dl class="detail-info-list">

        {{{
          <dt>Alternate Names:</dt>
          <ifdef code="ca_entities.nonpreferred_labels.displayname">
            <dd>
            <?php
              foreach($alternateNames as $index=>$altName){
                $is_displayed = ($alternateNamesDisplay[$index] == "88");
                if($is_displayed){
                  echo $altName . '<br>';
                }
              }
            ?>
            </dd>
            </ifdef>
            <ifnotdef code="ca_entities.nonpreferred_labels.displayname">
              <dd>–</dd>
            </ifnotdef>
        }}}
        

          {{{<ifdef code="ca_entities.vital_dates_ind.vital_date_ind">
            <dt>Vital Dates:</dt>
            <dd>
            <?php
              foreach($dateObjArray as $vitalDate){
                echo $vitalDate->date_type . ': ' . $vitalDate->date . '<br>';
              }
            ?>
            </dd>
          </ifdef>}}} 
        </dl>
      </div>
    </div>

    {{{<ifdef code="ca_entities.biography.biography_text">

        <div class="detail-info-box fw-border-top accordion">
          <div class="container">
            <div class="detail-info-box-header">
              <h2>Biography</h2>
              <button class="button accordion-toggle">Hide</button>
            </div>
            <div class="accordion-details" aria-expanded="true">
              <p class='unit detail-info-paragraph'>^ca_entities.biography.biography_text</p>
            </div>
          </div>
        </div>
    </ifdef>}}}

    {{{<ifdef code="ca_collections">
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Related Collections</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <div class="accordion-details" aria-expanded="true">
          <div class="detail-link-container">
					  <unit relativeTo="ca_entities_x_collections" delimiter=" "><unit relativeTo="ca_collections"><l><div class="detail-related-link">^ca_collections.preferred_labels.name</div></l></unit></unit>
          </div>
        </div>
      </div>
    </div>
    </ifdef>

    <ifdef code="ca_occurrences">
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Related Exhibitions</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <div class="accordion-details" aria-expanded="true">
          <div class="detail-link-container">
					  <unit relativeTo="ca_entities_x_occurrences" delimiter=" "><unit relativeTo="ca_occurrences" delimiter="<br/>"><l><div class="detail-related-link">^ca_occurrences.preferred_labels.name</div></l></unit></unit>
          </div>
        </div>
      </div>
    </div>
    </ifdef>}}}

    {{{<ifcount code="ca_objects" min="1">
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Related Records</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
      </div>
      <div class="accordion-details" aria-expanded="true">
        <div class="container">
          <div class="result-objects result-objects--grid">
            <div id="browseResultsContainer">
              <?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
            </div><!-- end browseResultsContainer -->
          </div>
        </div><!-- end row -->
      </div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
    </ifcount>}}}

</article>
