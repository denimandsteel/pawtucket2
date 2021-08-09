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

  if(!empty($va_collection_children)){

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
					if($qr_collection_children->numHits()){
            $index = 0;
            while($qr_collection_children->nextHit()) {

              $current_item_id = $t_item->get('ca_collections.collection_id');
              $list_class = ($index > 4) ? 'collection-item--hidden ' : '';
              
              print "<li class='collection-item  ".$list_class ."' id='collection".$qr_collection_children->get('ca_collections.collection_id')."'>";
							# --- link open in panel or to detail
							$va_grand_children_type_ids = $qr_collection_children->get("ca_collections.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
              
							print "</li>";	

              $list_length = $qr_collection_children->numHits();

              if($index == 5){
                $count_more_results = $list_length - 5;
                print "<li><button class='button see-more'>".$count_more_results." More</button></li>";
              }
                
?>													
            <script>
              $(document).ready(function(){
                $('#collection<?php print $qr_collection_children->get("ca_collections.collection_id");?>').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id"), 'current_id' => $current_id ), array('useQueryString' => true)); ?>", undefined, function() {
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
              $index++;
						}
					}
?>
								</ul></div><!-- end findingAidContainer -->
							<!-- </div>end col -->
				<!-- </div>end row						 -->
<?php
	}
?>			