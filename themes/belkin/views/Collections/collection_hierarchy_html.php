<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_has_children = false;
	$vb_has_grandchildren = false;
  $current_id = $this->request->getParameter("current_id", pString);
  $va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'));
  $va_collection_related_objects = $t_item->get("ca_objects.object_id", array("returnAsArray" => true,'checkAccess' => $va_access_values));


  if(!empty($va_collection_children) || !empty($va_collection_related_objects)){

		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_collections", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				if($qr_collection_children->get("ca_collections.children.collection_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
					$vb_has_grandchildren = true;
				}
			}
		}
		$qr_collection_children->seek(0);
	}
	if($vb_has_children){
?>					
				<div class="hierarchy accordion" id="collectionsWrapper">	
          
<?php
          print "<div class='collection-item collection-item--fond'><div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>".$t_item->get('ca_collections.idno')."  ".caDetailLink($this->request, $t_item->get('ca_collections.preferred_labels.name'), '', 'ca_collections',  $t_item->get("ca_collections.collection_id"))."</span><span class='collection-level'>". $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</span></div><button class='button accordion-toggle'>Hide</button></div>";
          print "<ul class='collection collection--child accordion-details accordion' aria-expanded='true'>";

          $all_children = []; // objects AND collections

          $va_child_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, 'sort' => array('ca_objects.idno_sort'), 'checkAccess' => $va_access_values));

          if($va_child_object_ids) {
            $qr_objects = caMakeSearchResult('ca_objects', $va_child_object_ids); 
  
            if($qr_objects->numHits()){
              while($qr_objects->nextHit()) {
                // store data in obj
                $obj = new stdClass();
                $obj->id = $qr_objects->get('ca_objects.object_id');
                $obj->idno = $qr_objects->get('ca_objects.idno');
                $obj->idno_sort = $qr_objects->get('ca_objects.idno_sort');
                $obj->preferred_labels = $qr_objects->get('ca_objects.preferred_labels');
                $obj->type = "object";
                $obj->level = "Item";
                $obj->link = caDetailLink($this->request, $qr_objects->get('ca_objects.idno') ." " . $qr_objects->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_objects->get('ca_objects.object_id'));

                $all_children[] = $obj;

              }
            }
          }

   

					if($qr_collection_children->numHits()){

            while($qr_collection_children->nextHit()) {
              // store data in obj
              $coll = new stdClass();
              $coll->id = $qr_collection_children->get('ca_collections.collection_id');
              $coll->idno = $qr_collection_children->get('ca_collections.idno');
              $coll->idno_sort = $qr_collection_children->get('ca_collections.idno_sort');
              $coll->preferred_labels = $qr_collection_children->get('ca_collections.preferred_labels');
              $coll->type = "collection";
              $coll->level = $qr_collection_children->get('ca_collections.level_description', array('convertCodesToDisplayText' => true));
              $coll->link = caDetailLink($this->request, $qr_collection_children->get('ca_collections.idno') ." " . $qr_collection_children->get('ca_collections.preferred_labels'), '', 'ca_collections', $qr_collection_children->get('ca_collections.collection_id'));
              
              // $coll->link = caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id"), 'current_id' => $current_id ), array('useQueryString' => true));

              // store obj in array
              $all_children[] = $coll;

						}
          }

          // sort array by idno_sort
          function id_sort($a, $b) {
            return strcmp($a->idno_sort, $b->idno_sort);
          }
          
          usort($all_children, "id_sort");

            // Loop through $all_children, print
            $index = 0;

          foreach($all_children as $child){

            switch($child->level){
              case "Sous-fonds":
                $list_class = "collection-item--sousfond ";
                break;
              case "Series":
                $list_class = "collection-item--series ";
                break;
              case "Sub-series":
                $list_class = "collection-item--subseries ";
                break;
              default: //files and objects
                $list_class = "collection-item--file ";
                break;
            }

            $is_current_item = ($child->id == $current_id);

            $list_class .= ($index > 4 && !$is_current_item && ( $child->level == "File" || $child->level == "Item" )) ? 'collection-item--hidden ' : '';

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
            print "</span><span class='collection-level'>". $child->level ."</span></div><span class='collection-bar-spacer'></span></div>";
            $index++;

            if( $child->level !== "File" && $child->level !== "Item"){
            ?>													
            <script>
              $(document).ready(function(){
                $('#collection<?php print $child->id;?>').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $child->id, 'current_id' => $current_id ), array('useQueryString' => true)); ?>", undefined, function() {
                	$current_item = $(this).find('.collection-item--current');
                  $parent_lists = $current_item.parents('li.accordion');
                  $current_item.removeClass('accordion--hidden');
                  $parent_lists.removeClass('accordion--hidden');
                  $toggles = $parent_lists.find('.accordion-toggle');
                  $details = $parent_lists.find('.accordion-details');
                  $hidden_childen = $details.children('.collection-item--hidden');
                  $see_more_btns = $details.find('.see-more');
                  $see_more_btns.hide();
                  $hidden_childen.removeClass('collection-item--hidden');
                  $toggles.text('Hide');
                  $details.attr('aria-expanded', true).removeAttr('style');

                }); 
              });
            </script>
          <?php			
            }
					}
?>
								</ul></div><!-- end findingAidContainer -->
							<!-- </div>end col -->
				<!-- </div>end row						 -->
<?php
	}
?>			