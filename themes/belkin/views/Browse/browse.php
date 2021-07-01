<?php
  if (!$vb_ajax) {	// !ajax
?>
<div class="results collections">
  <div class="container">
    <h1>Online Collections</h1>
    <div class="collections-intro">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
      <div class="collections-intro-tips spaced-content">
        <a class="link" href="/pawtucket/index.php/Browse/entities">More About the Collections</a>
      </div>
    </div>
    <nav>
      <ul class="collections-nav">
        <li><a href="/">Search + Explore</a></li>
        <li><a class="active" href="">Browse</a></li>
      </ul>
    </nav>
  </div>

  <div class="browse-links filters fw-border-top fw-border-bottom">
    <div class="filter container">
      <ul class="filter-list">
        <li class="filter-item button toggle active"><a href="/pawtucket/index.php/Browse/entities">Artist/Creator</a></li>
        <!-- <li class="filter-item button toggle"><a href="/pawtucket/index.php/Browse/objects">Objects</a></li> -->
        <li class="filter-item button toggle"><a href="/pawtucket/index.php/Browse/occurrences">Exhibitions</a></li>
        <li class="filter-item button toggle"><a href="/pawtucket/index.php/Browse/collections">Fonds/Collection</a></li>
      </ul>
    </div>
  </div>

</article>  
<?php
  }	// !ajax
?>
<form id="setsSelectMultiple">
		<div class="container">
			<div id="browseResultsContainer" class="browse-grid">
<?php

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
?>
});

</script>