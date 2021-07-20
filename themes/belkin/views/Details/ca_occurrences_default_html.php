<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb">Exhibition</div>
  </nav>

  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
        {{{<ifdef code="ca_occurrences.preferred_labels.name">
            <h1>^ca_occurrences.preferred_labels.name</h1>
        </ifdef>}}}
        <dl class="detail-info-list">

          {{{<ifdef code="ca_occurrences.exhibit_date">
            <dt>Start Date</dt>
            <dd>^ca_occurrences.exhibit_date.exhibit_datestart</dd>
          </ifdef>}}} 

          {{{<ifdef code="ca_occurrences.exhibit_date">
            <dt>End Date</dt>
            <dd>^ca_occurrences.exhibit_date.exhibit_dateend</dd>
          </ifdef>}}} 



          
          {{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1"><dt>Curator</dt></ifcount>}}}
          {{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2"><dt>Curators</dt></ifcount>}}}

          {{{<unit restrictToRelationshipTypes="curator" relativeTo="ca_entities" delimiter="<br/>"><l>
            <dd>^ca_entities.preferred_labels.forename, ^ca_entities.preferred_labels.surname</dd>
          </l></unit>}}}



          {{{<ifdef code="ca_occurrences.exhibition_location">
            <dt>Exhibition Location</dt>
            <dd>^ca_occurrences.exhibition_location</dd>
          </ifdef>}}}
        </dl>
      </div>
    </div>
  </div>

  {{{<ifcount code="ca_objects" min="2">
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
            <div id="browseResultsContainer" class="container">
              <?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
            </div><!-- end browseResultsContainer -->
          </div>
        </div><!-- end row -->
      </div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
