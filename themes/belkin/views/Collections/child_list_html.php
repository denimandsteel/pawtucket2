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

// sort array by idno_sort
function id_sort($a, $b) {
  return strcmp($a->idno_sort, $b->idno_sort);
}

function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array(), $t_item, $current_id, $va_object_ids) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
	$index = 0;


  if($qr_objects && $qr_objects->numHits()){
		while($qr_objects->nextHit()) {
      // store data in obj
      $obj = new stdClass();
      $obj->id = $qr_objects->get('ca_objects.object_id');
      $obj->idno = $qr_objects->get('ca_objects.idno');
      $obj->idno_sort = $qr_objects->get('ca_objects.idno_sort');
      $obj->preferred_labels = $qr_objects->get('ca_objects.preferred_labels');
      $obj->type = "object";
      $obj->level = "Item";
      $obj->link = caDetailLink($po_request, $qr_objects->get('ca_objects.idno') ." " . $qr_objects->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_objects->get('ca_objects.object_id'));
      $obj->child_object_ids = [];
      $obj->child_collection_ids = [];
      $all_children[] = $obj;
    }
  }

	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
      # --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
        continue;
			}

      // store data in obj
      $coll = new stdClass();
      $coll->id = $qr_collections->get('ca_collections.collection_id');
      $coll->idno = $qr_collections->get('ca_collections.idno');
      $coll->idno_sort = $qr_collections->get('ca_collections.idno_sort');
      $coll->preferred_labels = $qr_collections->get('ca_collections.preferred_labels');
      $coll->type = "collection";
      $coll->level_code = $qr_collections->get('ca_collections.level_description');
      $coll->level = $qr_collections->get('ca_collections.level_description', array('convertCodesToDisplayText' => true));
      $coll->link = caDetailLink($po_request, $qr_collections->get('ca_collections.idno') ." " . $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections', $qr_collections->get('ca_collections.collection_id'));
       
      // related object children
      $coll->child_object_ids = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'sort' => array('ca_objects.idno_sort'), 'checkAccess' => $va_access_values));

      $coll->child_collection_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));

      // add to array with objects
      $all_children[] = $coll;
		}
	}
	// return $vs_output;
  
  usort($all_children, "id_sort");

  // loop through objects/collections and display them

  $index = 0;

  foreach($all_children as $child){
    
    switch($child->level_code){
      case 163: //sous-fonds
        $list_class = "collection-item--sousfond ";
        break;
      case 164://series
        $list_class = "collection-item--series ";
        break;
      case 165://sub-series - never used
        $hierarchy_class = "collection-item--subseries ";
        break;
      default: //files and objects
        $list_class = "collection-item--file ";
        break;
    }

    switch($vn_level){
      case 1:
        $hierarchy_class = "collection--gchild ";
        break;
      case 2:
        $hierarchy_class = "collection--ggchild ";
        break;
      case 3:
        $hierarchy_class = "collection--gggchild ";
        break;
    }

    $is_current_item = ($child->id == $current_id);

    $list_class .= ($index > 4 && !$is_current_item && ( $child->level == "File" || $child->level == "Item" )) ? 'collection-item--hidden ' : '';

    
    if(sizeof($child->child_collection_ids) || sizeof($child->child_object_ids)){
      $list_class .= ' accordion accordion--hidden';
    }

    if($is_current_item){ 
      $list_class .= ' collection-item--current';
    }

    if($index == 5){
      $count_more_results =  count($all_children) - 5;
      print "<li><button class='button see-more'>".$count_more_results." More</button></li>";
    }

    print "<li id='collection". $child->id . "' class='collection-item " . $list_class ."' data-index='". $index ."'>";
    print "<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>";
    print  $child->link;
    print "</span><span class='collection-level'>". $child->level ."</span>";
    
    if(sizeof($child->child_collection_ids) || sizeof($child->child_object_ids)) {
      print "</div><button class='button accordion-toggle'>Show</button></div>";
    }else{
      print "</div><span class='collection-bar-spacer'></span></div>";
    }
    if(sizeof($child->child_collection_ids) || sizeof($child->child_object_ids)) {
      print "<ul class='collection ". $hierarchy_class. " accordion-details' aria-expanded='false' style='height:0px'>";
      print printLevel($po_request, $child->child_collection_ids, $o_config, $vn_level + 1, $va_options, $t_item, $current_id, $child->child_object_ids);
      print "</ul>";
    }
    print "</li>";
    
    // if ($vn_level > 1 && $index == 5) {
    //   $count_more_results = (74 - 5);
    //   print "<li><button class='button see-more'>".$count_more_results." More</button></li>";
    // }

    $index++;
  }
}

if ($vn_collection_id) {
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels), $t_item, $current_id, null);
}



?>