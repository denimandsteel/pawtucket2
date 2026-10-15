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
          print "<div class='collection-item collection-item--fond'><div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>" . caDetailLink($this->request, $t_item->get('ca_collections.preferred_labels.name'), '', 'ca_collections',  $t_item->get("ca_collections.collection_id"))."</span><span class='collection-level'>". $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</span></div><button class='button accordion-toggle'>Hide</button></div>";
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
                $obj->link = caDetailLink($this->request, $qr_objects->get('ca_objects.idno') . " " . $qr_objects->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_objects->get('ca_objects.object_id'));

                $all_children[] = $obj;

              }
              $seen = [];
              $all_children = array_filter($all_children, function($obj) use (&$seen) {
                if (in_array($obj->id, $seen)) {
                  return false;
                }
                $seen[] = $obj->id;
                return true;
              });
              usort($all_children, function($a, $b) {
                return strnatcasecmp($a->idno, $b->idno);
              });
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
            $seen = [];
            $all_children = array_filter($all_children, function($coll) use (&$seen) {
              if (in_array($coll->id, $seen)) {
                return false; 
              }
              $seen[] = $coll->id;
              return true;
            }); 
            usort($all_children, function($a, $b) {
               return strnatcasecmp($a->idno, $b->idno);
            });
          }

            // Loop through $all_children, print
            $index = 0;
          ?>
          <script>
            $(document).ajaxStop(function(){
                $current_id = "<?php echo $current_id; ?>";
                $all_items = <?php echo json_encode(array_map('strval', array_column($all_children, 'id'))); ?>;
                $current_index = $all_items.indexOf($current_id);
                console.log('current_index: ' + $current_index);
                if ($current_index === -1) {
                    $current_index = 0; // Default to the first item if not found
                    $current_item = $('#collection<?php echo $current_id; ?>');
                    $data_index = parseInt($current_item.attr('data-index'),10);
                    console.log('data_index: ' + $data_index);
                    if (typeof $data_index !== 'undefined') {
                      $('button.see-more-start, button.see-more-end').remove();
                      $('#collection<?php echo $current_id; ?>').siblings().first().removeClass('accordion--hidden');
                      $('#collection<?php echo $current_id; ?>').siblings().find('.collection-level:contains("Subseries")').each(function() {
                        $(this).parent().siblings('button').each(function() {
                          $(this).after("<span class='collection-bar-spacer'></span>");
                          $(this).remove();
                        });
                      });
                      $('#collection<?php echo $current_id; ?>').siblings().first().nextAll('.collection-item--file').first().before("<li><button class='button see-more-start'>More</button></li>");                      // );   
                      $('#collection<?php echo $current_id; ?>').siblings().last().after("<li><button class='button see-more-end'>More</button></li>");   
                      $('.hierarcy .accordion, .collection-item .accordion').each(function() {
                        if ($(this).find('#collection<?php echo $current_id; ?>').length === 0) {
                          $(this).find('button.button.accordion-toggle').text('Show');
                          $(this).find('.accordion-details').attr('aria-expanded', false).hide(); 
                        } else {
                          $count_before = 0;
                          $count_after = 0;
                          $('#collection<?php echo $current_id; ?>').prevAll('li.collection-item').has('span.collection-level:contains("Item"), span.collection-level:contains("File")').each(function() {
                            if (parseInt($(this).attr('data-index'),10) < $data_index - 3) {
                              $(this).addClass('collection-item--hidden');
                              $count_before++;
                            }
                          });
                          $('#collection<?php echo $current_id; ?>').nextAll('li.collection-item').has('span.collection-level:contains("Item"), span.collection-level:contains("File")').each(function() {
                            if (parseInt($(this).attr('data-index'),10) > $data_index + 3) {
                              $(this).addClass('collection-item--hidden');
                              $count_after++;
                            }
                          });
                          console.log('count_before: ' + $count_before);
                          if ($count_before > 0) {
                            $(this).find('.see-more-start').text($count_before + ' More').show();
                          } else {
                            $(this).find('.see-more-start').remove();
                          }
                          if ($count_after > 0) {
                            $(this).find('.see-more-end').text($count_after + ' More').show();
                          } else {
                            $(this).find('.see-more-end').remove();
                          }
                          console.log('count_after: ' + $count_after);
                        }
                      });
                    } 
                }
                $start_index = Math.max(0, $current_index - 2);
                $end_index = Math.min($all_items.length, $current_index + 5);
                
                $('.collection-item').each(function(index) {
                    if (index >= $start_index && index < $end_index) {
                        $(this).removeClass('collection-item--hidden');
                    } 
                });
            });
          </script>
          <?php
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

            //$list_class .= ($index > 4 && !$is_current_item && ( $child->level == "File" || $child->level == "Item" )) ? 'collection-item--hidden ' : '';
            $list_class .= (!$is_current_item && ( $child->level == "File" || $child->level == "Item" )) ? 'collection-item--hidden ' : '';

            if($is_current_item){ 
              $list_class .= ' collection-item--current';
            }

            if(($index == 0) || ($index == count($all_children) - 1)) {
              $current_item_index = array_search($current_id, array_column($all_children, 'id'));
              $start = max(0, $current_item_index - 3);
              $end = min(count($all_children), $current_item_index + 5);
              if($index == 0 && $start > 0) {
                print "<li><button class='button see-more-start'>".$start." More</button></li>";
              } elseif($index == count($all_children) - 1 && $end < count($all_children)) {
                print "<li><button class='button see-more-end'>".(count($all_children) - $end)." More</button></li>";
              }
            }

            print "<li id='collection". $child->id . "' class='collection-item " . $list_class ."' data-index='". $index ."'>";
            print "<div class='collection-bar'><div class='collection-bar-content'><span class='collection-title'>";
            print  $child->link;
            print "</span><span class='collection-level'>". $child->level ."</span></div><span class='collection-bar-spacer'></span></div>";
            $index++;

            if( $child->level !== "File" && $child->level !== "Item"){
            ?>													
            <script>
              $(document).one('ajaxStop',function(){
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
