<?php
$va_facets 			= $this->getVar('facets');				// array of available browse facets

$uri = parse_url($_SERVER['REQUEST_URI']);

$current_page = basename($uri['path']);
$query = $uri['query'];
$param = substr($query, strpos($query, "=") + 1);



$vs_facet_name = $param . '_facet';
$page_facet_items = $va_facets[$vs_facet_name]['content'];

if($param == 'decade'){
  $page_facet_items = array_reverse($va_facets[$vs_facet_name]['content']);
}

print '<div class="container"><div class="browse-links-columns">';
foreach($page_facet_items as $va_item) {
  // $vs_result_output = "
  // <div class='browse-links-item'>
  //     {$vs_label_detail_link}
  // </div>";
  // Clear cache??
  print "<div>".caNavLink($this->request, $va_item['label'].' ('.$va_item['content_count'].')', '', '*', 'Search','*', array('facet' => $vs_facet_name, 'id'=>$va_item['id']))."</div>";
}

print '</div></div>';
?>