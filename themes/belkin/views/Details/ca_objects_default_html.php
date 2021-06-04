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
	require_once(__CA_LIB_DIR__."/Search/ObjectSearch.php");
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>

<div class="row">
	<div class="container">
		<p>{{{resultsLink}}}</p>
		{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> / </ifcount>}}}{{{ca_objects.preferred_labels.name}}}
	</div>
</div>
<div class="row">
	<div class="container">
		{{{representationViewer}}}
		<div id="detailAnnotations"></div>
		
		<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
	</div>
</div>
<div class="row">
	<div class="container">
		<h3><!-- {{{<unit>^ca_objects.type_id</unit>}}} --> Object</h3>
		
		<h1>{{{^ca_objects.preferred_labels.name}}}</h1>
		
		<?php
			$o_search = new ObjectSearch();
			$results = $o_search->search("*", ['id' => $vn_id]);

			$artist = $t_object->get("ca_entity_labels.displayname");

			if (!empty($artist)) {
				print "<h3>Artist</h3>";
				print "<p>" . $artist . "</p>";
			}
		?>
		
		<h3>Date</h3>
		<p>{{{^ca_objects.pub_date}}}</p>
		
		<h3>Catalog Number</h3>
		{{{<ifdef code="ca_objects.idno"><p>^ca_objects.idno</p></ifdef>}}}
	</div>
</div>
<div class="row">
	<div class="container">
		<h2>Physical Description</h2>

		<h3>Physical Extent</h3>

		<h3>Object Type</h3>

		{{{<ifdef code="ca_objects.description">
			<h3>Description</h3>
				<p>^ca_objects.description</p>
			</div>
		</ifdef>}}}

		<h3>Dimensions</h3>
	</div>
</div>
<div class="row">
	<div class="container">
		<h2>Collection History</h2>

		<h3>Collection</h3>
		<p></p>

		<h3>Credit Line</h3>

		<h3>Dimensions</h3>
	</div>
</div>

	
		
			
				
				
				
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					//print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<!-- <div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php //print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div> --><!-- end detailTool -->
						<!-- <div id='detailComments'><?php //print $this->getVar("itemComments");?></div> --><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						// print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						// print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					// print '</div><!-- end detailTools -->';
				}				

?>


			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
			
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit> (^relationship_typename)</unit>}}}
							
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
						


<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>