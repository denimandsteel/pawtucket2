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

	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){

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
          print "<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>".$t_item->get('ca_collections.idno')." ".$t_item->get('ca_collections.preferred_labels.name')."</span><span class='collection-level'>". $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</span></div><button class='button accordion-toggle'>Hide</button></div>";
          print "<ul class='collection collection--child accordion-details accordion' aria-expanded='true'>";
					if($qr_collection_children->numHits()){
            $index = 0;
            while($qr_collection_children->nextHit()) {

              $current_item_id = $t_item->get('ca_collections.collection_id');
              $list_class = ($index > 4) ? 'collection-item--hidden ' : '';
              
              print "<li class='collection-item accordion ".$list_class."' id='collection".$qr_collection_children->get('ca_collections.collection_id')."'>";

							# --- link open in panel or to detail
							$va_grand_children_type_ids = $qr_collection_children->get("ca_collections.children.type_id", array('returnAsArray' => true, 'checkAccess' => $va_access_values));

							print "</li>";	

              $list_length = $qr_collection_children->numHits();

              if($index == 5){
                $count_more_results = $list_length - 5;
                $vs_output .= "<li><button class='button see-more'>".$count_more_results." More</button></li>";
              }
                
?>													
            <script>
              $(document).ready(function(){
                $('#collection<?php print $qr_collection_children->get("ca_collections.collection_id");?>').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('collection_id' => $qr_collection_children->get("ca_collections.collection_id"), 'current_id' => $current_id ), array('useQueryString' => true)); ?>", undefined, function() {
                	$current_item = $(this).find('.collection-item--current');
                	$accordion_details = $(this).find('.accordion-details').has($current_item);
                	$toggle = $(this).find('.accordion-details').has($current_item).prev().find('.accordion-toggle');
                	if ($current_item.length && $accordion_details.length && $toggle.length) {
                		$current_item.removeClass('accordion--hidden');
                		$accordion_details.attr('aria-expanded', true).removeAttr('style');
                		if ($toggle.closest('.accordion--hidden').find('ul[aria-expanded="true"]').length) {
                			$toggle.text('Hide');
                		}
                	}
                }); 
              });
            </script>
<?php							
              $index++;
						}
					}
?>
								</ul><!-- end findingAidContainer -->
							<!-- </div>end col -->
				<!-- </div>end row						 -->
<?php
	}
?>			