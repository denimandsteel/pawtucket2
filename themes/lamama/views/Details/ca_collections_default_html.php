<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-lg-8 col-lg-offset-2 text-center'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}</H2>
					{{{<ifdef code="ca_collections.description">
						<div class='unit description'>
							<span class="trimText">^ca_collections.description.description_text<ifdef code="ca_collections.description.description_source"><br/><br/>^ca_collections.description.description_source</ifdef></span>
						</div>
					</ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12'>
					{{{<ifdef code="ca_collections.creationDate"><div class="unit"><label>Date</label>^ca_collections.creationDate</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1"><div class="unit"><label>Related <ifcount code="ca_entities" min="1" max="1">person</ifcount><ifcount code="ca_entities" min="2">people</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels (^relationship_typename)</l></unit></span>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work"><div class="unit"><label>Related work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="work"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="production"><div class="unit"><label>Related production<ifcount code="ca_occurrences" min="2" restrictToTypes="production">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="production"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="special_event"><div class="unit"><label>Related special event<ifcount code="ca_occurrences" min="2" restrictToTypes="special_event">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="special_event"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="lamama_venues"><div class="unit"><label>Related venue<ifcount code="ca_occurrences" min="2" restrictToTypes="lamama_venues">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="lamama_venues"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="off_site"><div class="unit"><label>Related offsite venue<ifcount code="ca_occurrences" min="2" restrictToTypes="off_site">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="off_site"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="tours"><div class="unit"><label>Related tour<ifcount code="ca_occurrences" min="2" restrictToTypes="tours">s</ifcount></label>
						<span class="trimText"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="tours"><l>^ca_occurrences.preferred_labels</l></unit></span>
					</div></ifcount>}}}
<?php
					$va_all_subjects = array();
				
					foreach(array("lcshNames", "lcshTopical", "lcshGeo") as $vs_field){
						$va_lc = $t_item->get("ca_collections.".$vs_field, array("returnAsArray" => true));
						$va_lc_names_processed = array();
						if(is_array($va_lc) && sizeof($va_lc)){
							foreach($va_lc as $vs_lc_terms){
								if($vs_lc_terms){
									$vs_lc_term = "";
									if($vs_lc_terms && (strpos($vs_lc_terms, " [") !== false)){
										$vs_lc_term = mb_substr($vs_lc_terms, 0, strpos($vs_lc_terms, " ["));
									}
									$va_all_subjects[] = caNavLink($this->request, $vs_lc_term, "", "", "Search", "objects", array("search" => "ca_objects.".$vs_field.": ".$vs_lc_term));
								}
							}
						}
					}
					if(is_array($va_all_subjects) && sizeof($va_all_subjects)){
						print "<div class='unit'><label>Subjects</label>".join(", ", $va_all_subjects)."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class='col-sm-12'><hr/></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		</div><!-- end container -->
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
		  maxHeight: 125
		});
	});
</script>