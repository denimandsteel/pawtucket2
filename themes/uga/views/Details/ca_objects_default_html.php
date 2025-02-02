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
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");

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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><!-- <ifcount min="1" code="ca_collections"> ➔ </ifcount> -->}}}
				<HR>
				<H2>{{{ca_objects.preferred_labels.name}}}</H6>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.instantiationMediaType"><H6>Media Type:</H6>^ca_objects.instantiationMediaType<br/></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationPhysical"><H6>Format:</H6>^ca_objects.instantiationPhysical<br/></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationDate.instantiationDateText"><H6>Date:</H6>^ca_objects.instantiationDate.instantiationDateType: ^ca_objects.instantiationDate.instantiationDateText<br/></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationTimeStart"><H6>Time Start:</H6>^ca_objects.instantiationTimeStart<br/></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationDuration"><H6>Duration:</H6>^ca_objects.instantiationDuration<br/></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationColors"><H6>Colors:</H6>^ca_objects.instantiationColors<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.instantiationAnnotation"><H6>Annotation</H6> ^ca_objects.instantiationAnnotation<br/></ifdef>}}}
				{{{<h6>Object Citation <i>(Beta)</i>: </H6><unit relativeTo="ca_occurrences">^ca_occurrences.preferred_labels.</unit> <ifdef code="ca_objects.instantiationDateText">^ca_objects.instantiationDateText.</ifdef> ^ca_collections.preferred_labels<ifdef code="ca_collections.collectionDate">, ^ca_collections.collectionDate</ifdef>. Walter J. Brown Media Archives and Peabody Awards Collection, The University of Georgia Libraries.}}} 
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
<?php
				if ($va_works = $t_object->getWithTemplate('<unit relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l><br/><br/><unit relativeTo="ca_occurrences.pbcoreAssetDate" delimiter="<br/>">^ca_occurrences.pbcoreAssetDate.pbcoreAssetDateText (^ca_occurrences.pbcoreAssetDate.pbcoreWorkDateType)</unit><br/><br/>^ca_occurrences.pbcoreDescription</unit>')){
					print "<h6>Related Work</h6>".$va_works;
				}
?>				
				
				<br/><br/>
				
				<button id="aeon_submit">Request Item</button>
				
				<form id="aeon_request" name="EADRequest" action="https://uga.aeon.atlas-sys.com/aeon/aeon.dll" method="post">
  <input type="hidden" name="AeonForm"     value="EADRequest"/>
  <input type="hidden" name="RequestType"  value="Loan"/>
  <input type="hidden" name="Location"     value="Media Brown"/>
  <input type="hidden" name="DocumentType" value="media"/>
  <input type="hidden" name="Site"         value="Media Archives"/>
<input type="checkbox" name="Request" value="1" checked style="display:none"/><input type="hidden" name="ItemTitle_1" value="{{{ca_objects.preferred_labels.name}}}"/><input type="hidden" name="CallNumber_1" value="{{{ca_objects.idno}}}"/><input type="hidden" name="ItemSubtitle_1" value="{{{ca_collections.preferred_labels.name}}}"/></form>
				<script src="/pawtucket2/assets/aeon/aeonRequestsDialog.min.js"></script>
				<script src="/pawtucket2/assets/jqote2/jquery.jqote2.min.js"></script>
				<style>
					.ui-dialog { z-index: 10000 !important ;}
					.requestDesc .label, .scheduled_date .label {
						font-size: 100%;
						color: black;
					}
					
				</style>
				 <script>
  var settings = {
              title:'Confirm your viewing request',
              url: 'https://uga.aeon.atlas-sys.com/aeon/aeon.dll',
              submitButtonSelector:'#aeon_submit',
              itemFields: [
                {
                  name: 'ItemTitle',
                  label: 'Object title'
                },
                {
                  name: 'CallNumber',
                  label: 'Identifier'
                },
								{
									name: 'ItemSubtitle',
									label: 'Collection'
								}
              ],
              globalFields: [
                { name: 'Location' },
                { name: 'DocumentType' },
                { name: 'Site' }
              ],
              'scheduledDateLabel':'Select a date from the calendar (below) to visit UGA Special Collections to view the material.',
              'userReviewLabel': 'Keep this request saved in your account for later review. IT WILL NOT BE SENT TO LIBRARIES STAFF FOR FULFILLMENT.',
              'footer': '<i>* Requested items will be grouped by container in the Aeon system.</i>',
              'cleanValues':  function(s){return s.replace(/(^\s*)|(\s*$)/g, "").replace(/(\n|\t)/g, '');},
              'compressRequests':true,
              'stripUnchecked':true,
              'selectAllButtonsPosition': 'none'

            };
						
						$('#aeon_submit').aeonRequestsDialog(settings);
				 </script>

				
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
