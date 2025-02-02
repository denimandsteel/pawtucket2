<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
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
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";

	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
		$vn_col_span = 12;
		$vn_col_span_sm = 12;
		$vn_col_span_xs = 12;
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			$t_list_item = new ca_list_items();
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
				$vs_arrow_link 			= caDetailLink($this->request, "<i class='fa fa-arrow-circle-right'></i>", "", $vs_table, $vn_id);
				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				
				$vs_add_to_set_link = "";
				if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
					$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
				}
				
				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template, array('checkAccess' => caGetUserAccessValues($this->request)));
				$vs_tmp = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.children' restrictToTypes='Synthesis,CaseStudies,Exercise,Presentation' aggregateUnique='1' unique='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='author'>^ca_entities.preferred_labels.displayname</unit></unit>", array("delimiter" => "~", "checkAccess" => caGetUserAccessValues($this->request)));
				$va_authors = array();
				$vs_authors = "";
				if($vs_tmp){
					$va_authors = explode("~", $vs_tmp);
				}
				if(sizeof($va_authors) > 5){
					$va_authors = array_slice($va_authors, 0, 5);
					$va_authors[] = "et al.";
				}
				if(sizeof($va_authors)){
					$vs_authors = _t("Authors").": ".join(", ", $va_authors);
				}
				# --- translations
				$vs_tmp_translation = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.related' restrictToRelationshipTypes='translation'><l>^ca_objects.language</l></unit>", array("delimiter" => ", ", "checkAccess" => caGetUserAccessValues($this->request)));
				
				print "
	<div class='col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
		<div class='bResItem'>
			<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids[]' value='{$vn_id}'></div>
			<div class='pull-right'>{$vs_arrow_link}</div>
			<H1>{$vs_label_detail_link}</H1>
			<div class='bResContent'>".
				$qr_res->getWithTemplate("<ifdef code='ca_objects.language'>"._t("Language").": ^ca_objects.language%delimiter=,_</ifdef>", array("convertCodesToDisplayText" =>true, 'checkAccess' => caGetUserAccessValues($this->request)))
			.(($vs_tmp_translation) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Also Available in: ".$vs_tmp_translation : "")
			."<br/>".$vs_authors."</div><!-- end bResContent -->
		</div><!-- end bResItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>