<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb">Artist/Creator</div>
  </nav>


  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
        {{{<h1>^ca_entities.preferred_labels.displayname</h1>}}}
        <dl class="detail-info-list">
        
          {{{<ifdef code="ca_entities.vital_dates_ind.vital_date_ind">
            <dt>Vital Dates:</dt>
            <dd>^ca_entities.vital_dates_ind.vital_date_ind</dd>
          </ifdef>}}} 

					
					{{{<ifcount code="ca_collections" min="1" max="1"><dt>Related collection</dt></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><dt>Related collections</dt></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>"><unit relativeTo="ca_collections"><l><dd class="detail-related-link">^ca_collections.preferred_labels.name</dd></l></unit></unit>}}}

					
					<!-- {{{<ifcount code="ca_entities.related" min="1" max="1"><dt>Related person</dt></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><dt>Related people</dt></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities" delimiter="<br/>"><l><dd class="detail-related-link">^ca_entities.related.preferred_labels.displayname</dd></l></unit></unit>}}}
					 -->
					{{{<ifcount code="ca_occurrences" min="1" max="1"><dt>Related exhibition</dt></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><dt>Related exhibitions</dt></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l><dd class="detail-related-link">^ca_occurrences.preferred_labels.name</dd></l></unit></unit>}}}
					
					<!-- {{{<ifcount code="ca_places" min="1" max="1"><dt>Related place</dt></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><dt>Related places</dt></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_places" delimiter="<br/>"><unit relativeTo="ca_places" delimiter="<br/>"><l><dd class="detail-related-link">^ca_places.preferred_labels.name</dd></l></unit></unit>}}}		 -->


        </dl>
      </div>
    </div>

    
    {{{<ifdef code="ca_entities.biography">
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Biography</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <p class="accordion-details" aria-expanded="true">
					 <div class='unit detail-info-paragraph'>^ca_entities.biography</div>
              
          </p>
      </div>
    </div>
    </ifdef>}}}

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
