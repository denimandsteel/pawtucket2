<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");	
	$va_access_values = $this->getVar("access_values");
	$va_cover_items = $t_item->get("ca_objects.object_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values));
	$va_featured_items = $t_item->get("ca_objects.object_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values));
	$va_featured_collections = $t_item->get("ca_collections.related", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values));
	$va_detail_collections = $t_item->get("ca_collections.related", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("history"), "checkAccess" => $va_access_values));
	$qr_res = ca_collections::find(['parent_id' => $t_item->get('ca_collections.collection_id'), 'access' => 1], ['returnAs' => 'searchResult']);
	$qr_object_res = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'searchResult', 'restrictToTypes' => 'newspaper_article']);
	$vs_default_placeholder = caGetThemeGraphic($this->request, 'placeholder.jpg');
?>
<div class="row">
</div><!-- end row -->
<div class="row">		
<div class='col-sm-8'>
<?php
		if(is_array($va_cover_items) && sizeof($va_cover_items)){
			$vn_cover_id = $va_cover_items[0];
			$t_cover_object = new ca_objects($vn_cover_id);
			if($vs_media = $t_cover_object->getWithTemplate("<l>^ca_object_representations.media.large</l>", array("checkAccess" => $va_access_values))){
				print "<div class='detailCoverObject'>".$vs_media;
				$vs_caption = $t_cover_object->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>');
				if($vs_caption){
					print "<p class='detailCaptionText'>".$vs_caption."</p>";
				}
				print "</div>";
			}			
		}
?>
	{{{<ifdef code="ca_collections.description"><p>^ca_collections.description</p></ifdef>}}}
	{{{<ifdef code="ca_collections.additional_info">
			<div class="detailMoreInfo" id="additional_info_link"><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;">Read More <span class="glyphicon glyphicon-arrow-down small"></span></a></div>
			<p id='additional_info' style='display:none;'>^ca_collections.additional_info<br/><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;" class="detailMoreInfo">Hide <span class="glyphicon glyphicon-arrow-up"></span></a></p>
	</ifdef>}}}

	<div class="row">
		{{{<ifcount code="ca_collections.children" min="1"><div class='btn btn-default'>Sub Categories</div></ifcount>}}}
		<div id="browseCollectionResultsContainer">
<?php
		while($qr_res->nextHit()){
			$vn_id = $qr_res->get('ca_collections.collection_id');
			$t_rel_coll = new ca_collections($vn_id);
			$va_rel_cover_items = $t_rel_coll->get("ca_objects.object_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values));
			if(is_array($va_rel_cover_items) && sizeof($va_rel_cover_items)){
				$vn_rel_cover_id = $va_rel_cover_items[0];
				$t_rel_cover = new ca_objects($vn_rel_cover_id);
				$vs_thumb = $t_rel_cover->getWithTemplate("^ca_object_representations.media.resultcrop", array("checkAccess" => $va_access_values));
				$vs_rep_detail_link = caDetailLink($this->request, $vs_thumb, '', 'ca_collections', $vn_id);		
			} else {
				$vs_rep_detail_link = caDetailLink($this->request, $vs_default_placeholder, '', 'ca_collections', $vn_id);
			}
			$vs_label_detail_link = $t_rel_coll->getWithTemplate("<l>^ca_collections.preferred_labels</l>");
			print "<div class='bResultItemCol col-xs-6 col-sm-4 col-md-4'>
				<div class='bResult'>
					{$vs_rep_detail_link}
					<div class='bResultText'>
						{$vs_label_detail_link}
					</div>
				</div>
			</div>";
		}
?>
		</div><!-- end browseResultsContainer -->
	</div>
	<div class="row">
		
<?php if($qr_object_res){ ?>
			{{{<ifcount code="ca_objects" min="1"><div class='btn btn-default'>Articles</div></ifcount>}}}
				<div id="browseObjectResultsContainer">
<?php
			$va_date_sort = [];
			while($qr_object_res->nextHit()){
				$vn_id = $qr_object_res->get('ca_objects.object_id');
				$t_rel_obj = new ca_objects($vn_id);
			
				if($vs_thumb){
					$vs_rep_detail_link = caDetailLink($this->request, $vs_thumb, '', 'ca_objects', $vn_id);		
				} else {
					$vs_rep_detail_link = caDetailLink($this->request, $vs_default_placeholder, '', 'ca_objects', $vn_id);
				}
				
				if($t_rel_obj->get("ca_objects.parent.idno")){
					$vs_label_detail_link = $t_rel_obj->getWithTemplate("<l><ifdef code='ca_objects.parent.date.dates_value'>^ca_objects.parent.date.dates_value: </ifdef>^ca_objects.preferred_labels</l>");
					$vs_date = $t_rel_obj->get("ca_objects.parent.date.dates_value");
					array_push($va_date_sort, ['label' => $vs_label_detail_link, 'date' => $vs_date]);
				} else {
					$vs_label_detail_link = $t_rel_obj->getWithTemplate("<l><ifdef code='ca_objects.date.dates_value'>^ca_objects.date.dates_value: </ifdef>^ca_objects.preferred_labels</l>");
					$vs_date = $t_rel_obj->get("ca_objects.date.dates_value");
					array_push($va_date_sort, ['label' => $vs_label_detail_link, 'date' => $vs_date]);
				}
				
			}
			
			usort($va_date_sort, function ($a1, $a2){
				return strtotime($a1['date']) > strtotime($a2['date']) ? -1 : 1; 
			});
			foreach($va_date_sort as $va_article){
				print "<div class='bResultItemCol col-xs-12'>
					<div class='detailRelatedTitle'>{$va_article['label']}</div>
				</div>";
			}
			print "</div><!-- end browseResultsContainer -->";
		}
?>
		
	</div>

<?php
		if(is_array($va_featured_items) && sizeof($va_featured_items)){
			$q_featured_objects = caMakeSearchResult('ca_objects', $va_featured_items);
			if($q_featured_objects->numHits()){
				print "<div class='row'><div class='col-sm-12'><div class='btn btn-default'>"._t("Featured Objects")."</div></div></div><!-- end row -->\n";
				$i = 0;
				while($q_featured_objects->nextHit()){
					if($i == 0){
						print "<div class='row'>";
					}
					if(!($vs_media = $q_featured_objects->getWithTemplate("<l>^ca_object_representations.media.resultcrop</l>", array("checkAccess" => $va_access_values)))){
						$vs_media = caGetThemeGraphic($this->request, 'placeholder.jpg');
					}
					$vs_caption = $q_featured_objects->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>');
					if($vs_caption){
						$vs_caption = "<div class='bResultText'>".$vs_caption."</div>";
					}
					
					print "<div class='bResultItemCol col-xs-6 col-sm-4 col-md-4'>
						<div class='bResult'>
							{$vs_media}
							{$vs_caption}
						</div>
					</div><!-- end col -->";
					$i++;
					if($i == 3){
						print "</div><!-- end row -->";
						$i = 0;
					}
				}
				if($i > 0){
					print "</div><!-- end row -->";
				}
			}
		}
?>	
	
</div><!-- end col -->
<div class='col-sm-4'>
	<div class="detailTitle">{{{^ca_collections.preferred_labels.name}}}</div>
	
	{{{<ifdef code="ca_collections.parent.preferred_labels"><div class='btn btn-default'>Parent Category</div>
	<unit relativeTo="ca_collections.parent">
		<div class='detailRelatedTitle text-center'><l>^ca_collections.preferred_labels</l></div>
		<!--<p>^ca_objects.date.dates_value</p>-->
	</unit></ifdef>}}}
<?php
	if ($va_links = $t_item->get('ca_objects.external_link', array('returnWithStructure' => true))) {
		print "<div class='btn btn-default'>Related links</div><div>";
		foreach ($va_links as $va_key => $va_link_t) {
			foreach ($va_link_t as $va_key2 => $va_link) {
				if ($va_link['url_entry'] && $va_link['url_source']) {
					print "<p class='detailRelatedTitle'><a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_source']."</a></p>";
				} elseif ($va_link['url_entry']) {
					print "<p class='detailRelatedTitle'><a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_entry']."</a></p>";
				}
			}
		}
		print "</div>";
	}
	$t_object_thumb = new ca_objects();
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_entities)){
		if(sizeof($va_entities) == 1){
			print "<div class='btn btn-default'>Related person/organisation</div>";
		}else{
			print "<div class='btn btn-default'>Related people/organisations</div>";
		}
		$t_rel_entity = new ca_entities();
		$i = 0;
		foreach($va_entities as $va_entity){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_entity->load($va_entity["entity_id"]);
			$t_object_thumb->load($t_rel_entity->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_entity->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_entities.preferred_labels.displayname</l></div>");
			if($vs_brief_description = $t_rel_entity->get("ca_entities.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	#featured collections
	if(is_array($va_featured_collections) && sizeof($va_featured_collections)){
		$q_featured_collections = caMakeSearchResult('ca_collections', $va_featured_collections);
		if($q_featured_collections->numHits()){
			print "<div class='btn btn-default'>Featured Collection".((sizeof($va_featured_collections) > 1) ? "s" : "")."</div>";
			$i = 0;
			while($q_featured_collections->nextHit()){
				if($i > 0){
					print "<HR/>";
				}
				if(!($vs_thumb = $q_featured_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><unit relativeTo='ca_object_representations' length='1'>^ca_object_representations.media.resultcrop</unit></unit>", array("checkAccess" => $va_access_values)))){
					$vs_thumb = caGetThemeGraphic($this->request, 'placeholder.jpg');
				}
				$vs_caption = $q_featured_collections->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>');
				print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
				print $q_featured_collections->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
				if($vs_brief_description = $q_featured_collections->get("ca_collections.brief_description")){
					print $vs_brief_description;
				}
				print "</div></div><!-- end row -->";
				$i++;
			}
		}
	}
	# Detail collections
	if(is_array($va_detail_collections) && sizeof($va_detail_collections)){
		$q_detail_collections = caMakeSearchResult('ca_collections', $va_detail_collections);
		if($q_detail_collections->numHits()){
			print "<div class='btn btn-default'>Detailed Histor".((sizeof($va_detail_collections) > 1) ? "ies" : "y")."</div>";
			$i = 0;
			while($q_detail_collections->nextHit()){
				if($i > 0){
					print "<HR/>";
				}
				if(!($vs_thumb = $q_detail_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><unit relativeTo='ca_object_representations' length='1'>^ca_object_representations.media.resultcrop</unit></unit>", array("checkAccess" => $va_access_values)))){
					$vs_thumb = caGetThemeGraphic($this->request, 'placeholder.jpg');
				}
				$vs_caption = $q_detail_collections->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>');
				print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
				print $q_detail_collections->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
				if($vs_brief_description = $q_detail_collections->get("ca_collections.brief_description")){
					print $vs_brief_description;
				}
				print "</div></div><!-- end row -->";
				$i++;
			}
		}
	}
	$t_object_thumb = new ca_objects();
	# Related Collections
	$va_collections = $t_item->get("ca_collections.related", array("returnWithStructure" => true, 'excludeRelationshipTypes' => array('featured', 'history'),"checkAccess" => $va_access_values));
	if(sizeof($va_collections)){
		print "<div class='btn btn-default'>Related Collection".((sizeof($va_collections) > 1) ? "s" : "")."</div>";
		$t_rel_collection = new ca_collections();
		$i = 0;
		foreach($va_collections as $va_collection){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_collection->load($va_collection["collection_id"]);
			$t_object_thumb->load($t_rel_collection->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_collection->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_collection->get("ca_collections.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_places = $t_item->get("ca_places", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_places)){
		print "<div class='btn btn-default'>Related place".((sizeof($va_places) > 1) ? "s" : "")."</div>";
		$t_rel_place = new ca_places();
		$i = 0;
		foreach($va_places as $va_place){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_place->load($va_place["place_id"]);
			$t_object_thumb->load($t_rel_place->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_place->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_places.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_place->get("ca_places.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_occurrences = $t_item->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_occurrences)){
		print "<div class='btn btn-default'>Related event".((sizeof($va_occurrences) > 1) ? "s" : "")."</div>";
		$t_rel_occurrence = new ca_occurrences();
		$i = 0;
		foreach($va_occurrences as $va_occurrence){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_occurrence->load($va_occurrence["occurrence_id"]);
			$t_object_thumb->load($t_rel_occurrence->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_occurrence->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_occurrences.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_occurrence->get("ca_occurrences.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	
?>
</div><!-- end col -->
</div><!-- end row -->
