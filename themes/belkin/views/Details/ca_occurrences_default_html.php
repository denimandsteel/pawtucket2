<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb"></div>
  </nav>


  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
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
          <!-- <dt>Related Exhibitions</dt>
          {{{<unit relativeTo="ca_exhibitions" delimiter="<br/>"><l><dd>^ca_exhibitions.preferred_labels.name</dd></l></unit>}}}
          <dd></dd>
          <dt>Exhibition History</dt>
          <dd></dd>         -->
        </dl>
      </div>
      </div>
    </div>
    <div class="detail-actions fw-border-top">
      <div class="container">
        <button class="button button--catalogue ">Export</button>
        <button class="button button--catalogue ">Contact us</button>
        <button class="button button--catalogue ">Share</button>
      </div>
    </div>
</article>

































<div class="row">
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.description"><label>About</label>^ca_occurrences.description<br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}

<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><label>Related collection</label></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><label>Related collections</label></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><label>Related occurrence</label></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><label>Related occurrences</label></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
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
</ifcount>}}}		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>