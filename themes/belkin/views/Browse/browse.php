<?php
// get uri to determine Browse view
  $uri = parse_url($_SERVER['REQUEST_URI']);

  $current_page = basename($uri['path']);
  $query = $uri['query'];
  $param = substr($query, strpos($query, "=") + 1);

  $activePage = $current_page;
  $pageClass = $activePage;
  if ($param){
    $activePage = $activePage . '?' .  $query;
    $pageClass = $param;
  }

  // Browse menu
  $browse_pages = array();
  $browse_pages["entities"] = "Artist/Creator";
  $browse_pages["occurrences"] = "Exhibitions";
  $browse_pages["collections"] = "Fonds/Collection";
  // $browse_pages["objects?section=type"] = "Object Type";
  $browse_pages["objects?section=decade"] = "Decade and Date";
  $browse_pages["objects?section=category"] = "Object Type";


  if (!$vb_ajax) {	// !ajax
?>
<div class="results collections">
  <div class="container">
    <h1>Online Collections</h1>
    <div class="collections-intro">
      <p>With over 5,000 artworks and 20,000 archival records, our collections focus on the Canadian avant-garde of the 1960s and 1970s, the international network developed at that time, and its role in the art of today.</p>
      <div class="collections-intro-tips spaced-content">
        <a class="link" href="https://belkin.ubc.ca/collections/">More About the Collections</a>
      </div>
    </div>
    <nav>
      <ul class="collections-nav">
        <li><a href="/pawtucket">Search and Explore</a></li>
        <li><a class="active" href="/index.php/Browse/entities">Browse</a></li>
      </ul>
    </nav>
  </div>

  <div class="browse-links filters fw-border-top fw-border-bottom">
    <div class="filter container">
      <ul class="filter-list">
        <?php
        foreach($browse_pages as $url => $title): ?>
          <li class="filter-item button toggle <?php if($url === $activePage):?>active<?php endif;?>"><a href="/index.php/Browse/<?php echo $url ?>"><?php echo $title ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</article>  
<?php
  }	// !ajax
?>
<form id="setsSelectMultiple" class="<?php print $pageClass ?>">
		<!-- <div class="container">
			<div id="browseResultsContainer" class="browse-grid"> -->
<?php


# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{

  switch($current_page){
    case 'entities':
      $vs_result_page = $this->render("Browse/browse_results_artists_html.php");
      break;

    case 'occurrences':
      $vs_result_page = $this->render("Browse/browse_results_exhibitions_html.php");
      break;

    case 'objects':
      $vs_result_page = $this->render("Browse/browse_results_facets_html.php");
      break;

    case 'collections':
      $vs_result_page = $this->render("Browse/browse_results_collections_html.php");
      break;
  }

	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		

// if (!$vb_ajax) {	// !ajax
  ?>
  <!-- </div>
</div> -->
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
	});

</script>