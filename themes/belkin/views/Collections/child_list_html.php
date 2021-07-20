<?php

	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_collapse_levels = $o_collections_config->get("collapse_levels");


function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array(), $t_item) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	$index = 0;
  $list_length = count($va_collection_ids);

	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {




			$vs_icon = "";
			# --- related objects?
			$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values)));
			$vn_rel_objects = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true,'checkAccess' => $va_access_values));

      
			// if(is_array($va_options["collection_type_icons"])){
        // 	$vs_icon = $va_options["collection_type_icons"][$qr_collections->get("ca_collections.type_id")];
        // }
        $va_child_collection_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
        $va_child_object_ids = $qr_collections->get("ca_collections.children.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));

      $va_child_ids = $va_child_collection_ids; //array_merge($va_child_collection_ids, $vn_rel_objects);
        

			# --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}


      switch($vn_level){
        case 1:
          $hierarchy_class = "collection--gchild";
          break;
        case 2:
          $hierarchy_class = "collection--ggchild";
          break;
        case 3:
          $hierarchy_class = "collection--gggchild";
          break;
      }

      //TODO
      // if this is current obj ->  only show 2 results before, and 2 results after
      $current_item_id = $t_item->get('ca_collections.idno');

      $is_current_item = ($qr_collections->get('ca_collections.idno') == $current_item_id);
      $is_collection = $t_item->get('ca_collections.idno');

      $list_class = ($index > 4) ? 'collection-item--hidden' : '';
      if($va_child_ids){
        $list_class .= ' accordion';
      }
			$vs_output .= "<li class='collection-item ".$list_class."' data-index='". $index ."'>";

      $vs_output.="<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>";
      
      if($is_current_item){
        $vs_output.="<strong>";
      }
			if($is_collection){
        $vs_output .= $qr_collections->get('ca_collections.idno') ." ". caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));

			}else{
        // $vs_output .= $qr_collections->get('ca_collections.idno') ." ". caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));

        $vs_output .= $qr_collections->get('ca_collections.idno')." ".$qr_collections->get('ca_collections.preferred_labels.name');
			}

      if($is_current_item){
        $vs_output.="</strong>";
      }
      $vs_output.="</span><span class='collection-level'>". $qr_collections->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</span>";

      if(sizeof($va_child_ids)) {
      $vs_output.="</div><button class='button accordion-toggle'>Hide</button></div>";
      }else{
        $vs_output.="</div><span class='collection-bar-spacer'></span></div>";
      }
			if(sizeof($va_child_ids)) {
        $vs_output .= "<ul class='collection ".$hierarchy_class." accordion-details' aria-expanded='true'>";
				$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options, $t_item);
        $vs_output .= "</ul>";
			}
			$vs_output .= "</li>";
      if($vn_level > 1 && $index == 5){
        $count_more_results = $list_length - 5;
        $vs_output .= "<li><button class='button see-more'>".$count_more_results." More</button></li>";
      }

      $index++;
		}
	}
	return $vs_output;
}

if ($vn_collection_id) {
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels), $t_item);
}



?>