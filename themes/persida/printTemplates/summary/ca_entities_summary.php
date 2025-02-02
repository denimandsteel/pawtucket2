<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Entities tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_entities
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>

	<div class='tombstone'>
<?php
		if ($va_name = $t_item->get('ca_entities.preferred_labels')) {
			print "<div class='unit'><H2>".$va_name."</H2></div>";
		}	
		if ($va_lifespan = $t_item->get('ca_entities.lifespan')) {
			print "<div class='unit'>".$va_lifespan."</div>";
		}
		if ($va_entity_notes = $t_item->get('ca_entities.entity_notes', array('delimiter' => '<br/>'))) {
			print "<div class='unit'>".$va_entity_notes."</div>";
		}
		if ($va_entities = $t_item->get('ca_entities.related.preferred_labels', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Related People & Organizations</h6>".$va_entities."</div>";
		}	
		if ($va_exhibitions = $t_item->get('ca_occurrences.preferred_labels', array('delimiter' => '<br/>', 'restrictToTypes' => array('exhibition')))) {
			print "<div class='unit'><h6>Related Exhibitions</h6>".$va_exhibitions."</div>";
		}
		$va_object_ids = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'sort' => 'ca_entities.preferred_labels.surname;ca_objects.object_id'));
		if ($va_object_ids) {	
			print "<hr/ style='border:0px;border-top:solid 1px #ccc;height:1px;'>";
			print "<table>";
			foreach ($va_object_ids as $va_key => $vn_object_id) {
				$t_object = new ca_objects($vn_object_id);
				print "<tr class='divide'>";
				print "<td class='metaData'>";
				print "<div>".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."</div>";
				print "<div>".$t_object->get('ca_objects.preferred_labels')."</div>";
				print "<div>".$t_object->get('ca_objects.creation_date')."</div>";
				print "<div>".$t_object->get('ca_objects.medium')."</div>";
				if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> x ^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">(</ifdef><ifdef code="ca_objects.dimensions.height_in">^ca_objects.dimensions.height_in H</ifdef><ifdef code="ca_objects.dimensions.width_in"> x ^ca_objects.dimensions.width_in W</ifdef><ifdef code="ca_objects.dimensions.depth_in"> x ^ca_objects.dimensions.depth_in D</ifdef><ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">)</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
					print "<div >".$vs_dimensions."</div>";
				} elseif ($vs_dimensions = $t_object->get('ca_objects.dimensions_readOnly')) {
					print "<div >".$vs_dimensions."</div>";
				}
				print "<div>".$t_object->get('ca_objects.edition')."</div>";
				print "<div>".$t_object->get('ca_objects.art_types', array('convertCodesToDisplayText' => true))."</div>";	
				print "<div>".$t_object->get('ca_objects.ca_objects_location')."</div>";			
				print "</td>";
				print "<td class='objImage'>".$t_object->get('ca_object_representations.media.small')."</td>";
				print "</tr>";
			}
			print "</table>";
		}
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");