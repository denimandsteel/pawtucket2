<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
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
 * ----------------------------------------------------------------------
 */

	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_is_advanced		= (int)$this->getVar('is_advanced');
	$vb_showLetterBar	= (int)$this->getVar('showLetterBar');	
	$va_letter_bar		= $this->getVar('letterBar');	
	$vs_letter			= $this->getVar('letter');
	$vn_row_id 			= $this->request->getParameter('row_id', pInteger);
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');

	$vn_result_size 	= (sizeof($va_criteria) > 0) ? $qr_res->numHits() : $this->getVar('totalRecordsAvailable');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info = $this->getVar("browseInfo");
	$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
	$o_config = $this->getVar("config");
	$vs_result_col_class = $o_config->get('result_col_class');
	$vs_refine_col_class = $o_config->get('refine_col_class');
	$va_export_formats = $this->getVar('export_formats');
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
?>
<article class="search-results">
  <h1>Online Catalogue</h1>
  <form class="search-form" action="/pawtucket/index.php/Search/objects" method="post">
    <!-- TODO, add Criteria dropdown?? -->
    <input class="search-input" name="search" type="text" placeholder="Search by"><button class="button button--search">Search</button>
  </form>
  
  <!-- Filters - are the checkboxes even possible?? How do I implement this, currently I only see simple filters -->
  <div class="search-results-filters">
  <?php
		print $this->render("Browse/browse_refine_subview_html.php");
  ?>	
  </div>
  
  <div class="search-results-header">
    <h2>
    <?php
			echo  $vn_result_size;
    ?>
     results found for 
    <?php
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				print "<strong> ".$va_criterion['facet'].':</strong>';
				if ($va_criterion['facet_name'] != '_search') {
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle" aria-label="Remove filter"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
				}else{
					print ' '.$va_criterion['value'];
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
    ?>		
    </h2>
    <div class="search-results-controls">
      <div id="searchViewmode" class="search-results-viewmode">
        <span>View</span>
        <button class="button" aria-pressed="false">Grid<i></i></button><button class="button" aria-pressed="true">List<i></i></button>
      </div>
      <div class="search-results-sort">
        <span>Sort</span>
      </div>
    </div>
  </div>
  <div id="searchResults" class="search-results">
    <div class="search-results-labels">
      <span>Image</span>
      <span>Record Type</span>
      <span>Title</span>
      <span>Artist</span>
      <span>Date</span>
      <span>Item #</span>
      <span>Excerpt</span>
    </div>
    <div class="search-result">
      <div>
        <img src="" alt="" width="300" height="200">
      </div>
      <span class="record-type">Object</span>
      <span><strong>Object Name</strong></span>
      <span>Artist Name</span>
      <span>1900</span>
      <span>ABCD.EF</span>
      <p>Lorem ipsum dolor sit amet...</p>
    </div>
    <div class="search-result">
      <div>
        <img src="" alt="" width="300" height="200">
      </div>
      <span class="record-type">Object</span>
      <span><strong>Object Name</strong></span>
      <span>Artist Name</span>
      <span>1900</span>
      <span>ABCD.EF</span>
      <p>Lorem ipsum dolor sit amet...</p>
    </div>
    <div class="search-result">
      <div>
        <img src="" alt="" width="300" height="200">
      </div>
      <span class="record-type">Object</span>
      <span><strong>Object Name</strong></span>
      <span>Artist Name</span>
      <span>1900</span>
      <span>ABCD.EF</span>
      <p>Lorem ipsum dolor sit amet...</p>
    </div>
    <div class="search-result">
      <div>
        <img src="" alt="" width="300" height="200">
      </div>
      <span class="record-type">Object</span>
      <span><strong>Object Name</strong></span>
      <span>Artist Name</span>
      <span>1900</span>
      <span>ABCD.EF</span>
      <p>Lorem ipsum dolor sit amet...</p>
    </div>
  </div>

</article>  

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
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
