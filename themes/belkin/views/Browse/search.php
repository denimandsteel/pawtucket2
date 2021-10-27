<?php
  if (!$vb_ajax) {	// !ajax
?>
<div <?php print caGetPageCSSClasses(); ?>>
  <div class="container">
    <?php include( dirname(__FILE__, 2).'/Search/ca_objects_advanced_search_objects_html.php'); ?>
  </div>

  <div class="fw-border-top">
    <div class="results-header container">
      <?php
      print '<h2 class="results-header-title">' . $vn_result_size . ' results</h2>';
      ?>	
      <div class='results-controls'>
        <div id='viewMode' class='results-view results-toggle'>
          <?php
            if(is_array($va_views) && (sizeof($va_views) > 1)){
              foreach($va_views as $vs_view => $va_view_info) {
                $viewmode_label = ($vs_view === "list") ? "list" : "grid"; //make 'images' mode label 'grid'
                $viewmode_icon = ($vs_view === "list") ? "<i class='fa fa-bars'></i>" : "<i class='fa fa-th'></i>"; //
                if ($vs_current_view === $vs_view) {
                  print '<a href="#" class="button active" role="button" aria-pressed="true">'.$viewmode_label. $viewmode_icon .'</a> ';
                } else {
                  print caNavLink($this->request, $viewmode_label . $viewmode_icon, 'button', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key), array('aria-pressed' => 'false', 'role' => 'button')).' ';
                }
              }
            }
          ?>
        </div>
        <div class='results-sort'>
        <?php
        if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<div id='bSortByList' class='dropdown'><button class='button dropdown-toggle'>"._t("Sort")."</button><ul class='dropdown-list hidden'>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='dropdown-option dropdown-option--active'>{$vs_sort}</li>\n";
						} else {
							print "<li class='dropdown-option'>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
					}
					print "</ul></div>\n";

          print "<div class='results-order results-toggle'>";
					print "<button class='button' aria-pressed=".(($vs_sort_dir == 'asc') ? '"false" disabled' : 'true').">".caNavLink($this->request, 'Asc', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."<i class='fa fa-sort-amount-asc'></i></button>";
					print "<button class='button' aria-pressed=".(($vs_sort_dir == 'asc') ? '"true"' : '"false" disabled').">".caNavLink($this->request, 'Desc', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."<i class='fa fa-sort-amount-desc'></i></button>";
					print "</div>\n";
					print "</div>\n"; // end results-sort
				
        }
        // Export as PDF links
        if(is_array($va_export_formats) && sizeof($va_export_formats)){
          print "<div class='results-export'>";
          print "<div class='dropdown'><button class='button dropdown-toggle'>"._t("Export Results")."</button><ul class='dropdown-list hidden'>\n";
          foreach($va_export_formats as $va_export_format){
            print "<li class='".$va_export_format["code"]." dropdown-option'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
          }
					print "</div>\n";

        }
        ?>
        </div>
      </div>
    </div>
  </div>

  <div class="results-filters">
    <div class="container">
      <?php
        print $this->render("Browse/browse_refine_subview_html.php");
      ?>	
    </div>
  </div>

  
  <div class="results-criteria fw-border-top fw-border-bottom">
    <div class="container">
        <?php
        session_start();

        if (sizeof($va_criteria) == 1 && $_SESSION['object_search_query_key'] != $vs_browse_key) {
          $_SESSION['object_search_query_key'] = $vs_browse_key;
        }

        if (sizeof($va_criteria) > 0) {
          $i = 0;
          print "<span>Selected</span>";
          print "<div class='container--wrap'>";
          foreach($va_criteria as $va_criterion) {
            if ($va_criterion['facet_name'] != '_search') {
              print caNavLink($this->request, $va_criterion['facet'].': '.$va_criterion['value'], 'button button--filter', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
            }else{
              print '<button type="button" class="button button--filter" disabled>'.$va_criterion['value'].'</button>';
              $vs_search = $va_criterion['value'];
            }
            $i++;
            if($i < sizeof($va_criteria)){
              print " ";
            }
            $va_current_facet = $va_all_facets[$va_criterion['facet_name']];
            if((sizeof($va_criteria) == 1) && !$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
              $t_authority_table = new $va_current_facet["table"];
              $t_authority_table->load($va_criterion['id']);
              $vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
            }
          }
        }

        if (sizeof($va_criteria) > 1) {
          print caNavLink($this->request, 'Clear All', 'button button--filter', '*', '*', '*', array('view' => $vs_current_view, 'key' => $_SESSION['object_search_query_key']));
        }
        if (sizeof($va_criteria) > 0) {
          print "</div>";
        }
        ?>		
    </div>
  </div>
  <form id="setsSelectMultiple">
		<div class="container">
			<div id="resultObjects" class="result-objects <?php if($vs_current_view === 'images'){ echo 'result-objects--grid';};?>">
        <div class="result-objects-labels">
          <span class="collections-only">Level</span>
          <span class="objects-only">Image</span>
          <span>Artist/Creator</span>
          <span>Title</span>
          <span>Date</span>
          <span>ID #</span>
          <span>Collection Type</span>
          <span>Fonds/Collection</span>
          <!-- <span>Level of Description</span> -->
        </div>
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		

// if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
</article>  

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#resultObjects').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 800,
			nextSelector: 'a.jscroll-next'
		});
<?php
		if($vn_row_id){
?>
			window.setTimeout(function() {
				$("window,body,html").scrollTop( $("#row<?php print $vn_row_id; ?>").offset().top);
			}, 0);
<?php
		}
		if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
?>
		jQuery('#setsSelectMultiple').on('submit', function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
<?php
		}
?>
	});

</script>