<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$t_set = $this->getVar("set");
	$va_set_comments = $t_set->getComments();
?>
<H1><?php print $this->getVar("label")."</H1>"; ?>
<div class="container">
	<div class="row">
		<div class="col-sm-8"><div id="galleryDetailImageArea">
			image here
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
		<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
	</div><!-- end row -->
</div><!-- end container -->
<div class="galleryDetailBottom"></div>

<div class="container">
	<div class="row">
<?php
	if($ps_description){
?>
		<div class="col-sm-4 setDescription">
			<?php print "<p>".$ps_description."</p>"; ?>
<?php
	#if(is_array($va_set_comments) && sizeof($va_set_comments)){
	#	print "<H6>Comments</H6><div style='max-height:200px; overflow-y:auto;'>";
	#	foreach($va_set_comments as $va_set_comment){
	#		print "<p style='font-weight:normal;'>".$va_set_comment["comment"]."</p>";
	#	}
	#	print "</div>";
	#}
?>
		</div><!-- end col -->
<?php
	}
?>	
		<div id="galleryDetailImageGrid" class="col-sm-<?php print ($ps_description) ? "8" : "12"; ?>">
			<div class="row">		
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			# --- is the iconlarge version available?
			$vs_icon = "icon";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			if($pa_set_item["representation_tag_".$vs_icon]){
				$vn_i++;
				#print "<div class='smallpadding col-xs-3 col-sm-2 col-md-".(($ps_description) ? "2" : "1").(($vn_i > 12) ? " galleryIconHidden" : "")."'>";
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-".(($ps_description) ? "1" : "1").(($vn_i > 36) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$pa_set_item["representation_tag_".$vs_icon]."</a>";
				print "</div>\n";
				
				if($vn_i == 36){
					print "<div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 36)." "._t("more")."</a>
							</div>";
				}
			}
		}
?>
			</div><!-- end row -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			galleryHighlightThumbnail("galleryIcon<?php print ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id; ?>");
		});
		function galleryHighlightThumbnail(id) {		
			jQuery("#galleryDetailImageGrid a").removeClass("galleryIconActive");
			jQuery("#" + id).addClass("galleryIconActive");
		}
</script>