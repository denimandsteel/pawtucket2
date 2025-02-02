<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
?>
	<div class="listing-content single-lists">

		<div id="filterByNameContainer">
			<div>
				<input type="text" name="filterByName" id="filterByName" placeholder="<?php print _t('author, title and keyword search');?>" value="" onfocus="this.value='';"/><a href="#" onclick="jQuery('.listEntry').css('display', 'block'); jQuery('#filterByName').val(''); return false;"> <i class="fa fa-close"></i> 
<?php		
			global $g_ui_locale;	
			if ($g_ui_locale == 'en_US'){			
				print "clear search";
			} else {
				print "Borrar búsqueda";
			}				
?>				
				</a>
			</div>
		</div>
<?php 

	$va_links_array = array();
	$va_letter_array = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		print "<h2>{$va_listing_info['displayName']}</h2>\n";		
		if ($va_listing_info['id'] == "sources") {
			print '<p>'._t('"Comprehensive sources" refers to bibliographies, catalogs, checklists, and indexes that include sueltas by several playwrights and are not limited to a single author. It is assumed that researchers investigating a particular dramatist will be thoroughly familiar with the scholarship on that person, including modern editions of his or her plays, which frequently discuss suelta editions.').'</p>';	
		} else {
			print '<p>'._t('This is a selective and narrowly focused bibliography of materials related to suelta studies. It does not reproduce the vast area of drama that once appeared in the Bulletin of the Comediantes or that continues to be gathered in the MLA Bibliography').'</p>';	
		}	
		while($qr_list->nextHit()) {
			$vs_first_letter = ucfirst(substr($qr_list->get('ca_occurrences.author'), 0, 1));
			$va_letter_array[$vs_first_letter] = $vs_first_letter;
			$vn_id = $qr_list->get('ca_occurrences.occurrence_id');
			$va_links_array[$vs_first_letter][$vn_id] = "<div class='listLink listEntry'><span class='listAuthor'>".$qr_list->get('ca_occurrences.author')."&nbsp;</span><span class='listTitle'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels</l>')."</span><span class='listPub'>&nbsp;".$qr_list->get('ca_occurrences.publication_info')."</span></div>\n";	
		}
		foreach ($va_links_array as $va_first_letter => $va_links) {
			print "<p class='separator'><a name='".$vs_first_letter."'></a><br></p>";			
			print "<h2 id='".$va_first_letter."' class='mw-headline'>".$va_first_letter."</h2>";
			foreach ($va_links as $va_occurrence_id => $va_link) {
				print $va_link;
			}
		}
	}
?>
	<div id='toc_container'>
		<div id='toc_content' class='arrow-scroll'>
			<ul id='tocList'>
<?php
	foreach ($va_letter_array as $va_key => $va_letter) {
		print "<li class='tocLevel2'><a class='tocLink' href='#".$va_letter."'>".$va_letter."</a></li>";
	}
?>
			</ul><!-- end tocList -->
			<div class="tocListArrow topArrow"></div>
			<div class="tocListArrow bottomArrow"></div>
		</div><!-- end toc_content -->
	</div><!-- end toc_container -->


	</div>
	
		<script type="text/javascript">
			
			// This will break in jQuery 1.8
			jQuery.extend($.expr[':'], {
			  'containsi': function(elem, i, match, array)
			  {
				return (elem.textContent || elem.innerText || '').toLowerCase()
				.indexOf((match[3] || "").toLowerCase()) >= 0;
			  }
			});
			jQuery(document).ready(function() {
				//prevent form submit with enter key
				jQuery('#filterByName').bind("keypress", function(e) {
					if (e.keyCode == 13) {
						return false;
					}
				});
				
				var typingTimer;
				
				//jQuery('#filterByName').css('color', '#eeeeee');
				jQuery('#filterByName').bind('keyup', function(e) {
					if (!jQuery('#filterByName').val()) { jQuery(".listEntry").css("opacity", 1.0); }
					typingTimer = setTimeout(function() {
						var t = jQuery('#filterByName').val();
						if (t.length > 0) {
							jQuery(".listEntry").css("display", "none");
							if (jQuery(".listEntry:containsi(" + t + ")").length) {
								jQuery(".mw-headline").addClass("noLetter");
								jQuery(".separator").addClass("noSeparator");
								jQuery(".listEntry:containsi(" + t + ")").css("display", "block");
							}
						} else {
							jQuery(".listEntry").css("opacity", "1.0");
						}
					}, 1500);
				});
				jQuery('#filterByName').bind('keydown', function(){
					clearTimeout(typingTimer);
					//jQuery('#filterByName').css('color', '#999999');
				});
				
				jQuery('#filterByName').bind('focus', function(){
					//jQuery('#filterByName').css('color', '#000000');
					if (jQuery('#filterByName').val() == 'Name') {
						jQuery('#filterByName').val('');
					}
				});
			});
		</script>	