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
  $current_id = $this->request->getParameter("current_id", pString);



function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array(), $t_item, $current_id) {
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
			# --- related objects?
			$va_child_object_ids = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true,'checkAccess' => $va_access_values));

      $va_child_collection_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));

			# --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}

      $hierarchy_type = $qr_collections->get('ca_collections.level_description');
      // echo '<pre>';
      // echo var_dump($hierarchy_type);
      // echo '</pre>';

      switch($hierarchy_type){
        // case 162: //fonds
        //   $hierarchy_class = "collection--gchild";
        //   break;
        case 163: //sous-fonds
          $list_class = "collection-item--sousfond";
          break;
        case 164://series
          $list_class = "collection-item--series";
          break;
        // case 165://sub-series - never used
        //   $hierarchy_class = "collection--ggchild";
        //   break;
        // case 166://file
        default: //files and objects
          $list_class = "collection-item--file";
          break;
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
      // echo '<pre>';
      // echo var_dump($current_id);
      // echo '</pre>';

      // $param = substr($query, strpos($query, "=") + 1);
      // $current_id = $t_item->get('ca_collections.collection_id');
      $is_current_item = ($qr_collections->get('ca_collections.collection_id') == $current_id);

      $list_class .= ($index > 4) ? ' collection-item--hidden ' : '';
      if(sizeof($va_child_collection_ids) || sizeof($va_child_object_ids)){
        $list_class .= ' accordion';
      }
      if($is_current_item){
        $list_class .= ' collection-item--current';
      }

			$vs_output .= "<li class='collection-item ".$list_class."' data-index='". $index ."'>";

      $vs_output.="<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>";
      

      $vs_output .= $qr_collections->get('ca_collections.idno') ." ". caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));

      $vs_output.="</span><span class='collection-level'>". $qr_collections->get('ca_collections.level_description', array('convertCodesToDisplayText' => true))."</span>";

      if(sizeof($va_child_collection_ids) || sizeof($va_child_object_ids)) {
      $vs_output.="</div><button class='button accordion-toggle'>Hide</button></div>";
      }else{
        $vs_output.="</div><span class='collection-bar-spacer'></span></div>";
      }
			if(sizeof($va_child_collection_ids) || sizeof($va_child_object_ids)) {
        $vs_output .= "<ul class='collection ". $hierarchy_class. " accordion-details' aria-expanded='true'>";
				$vs_output .=  printLevel($po_request, $va_child_collection_ids, $o_config, $vn_level + 1, $va_options, $t_item, $current_id);

			  $qr_objects = caMakeSearchResult('ca_objects', $va_child_object_ids); 

        if($qr_objects->numHits()){
          while($qr_objects->nextHit()) {
            $current_class = ($qr_objects->get('ca_objects.object_id') == $current_id) ? 'collection-item--current' : '';
            $vs_output.= "<li class='collection-item collection-item--file". $current_class ."' data-index='". $index ."'>";
            $vs_output.="<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>";
            $vs_output.= caDetailLink($po_request, $qr_objects->get('ca_objects.idno') ." " . $qr_objects->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_objects->get('ca_objects.object_id'));
            $vs_output.="</span><span class='collection-level'>". $qr_objects->get('ca_objects.catalogue_destination.preferred_labels') ."</span></div><span class='collection-bar-spacer'></span></div>";
          }
        }


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
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels), $t_item, $current_id);
}



?>