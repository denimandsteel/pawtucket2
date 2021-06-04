<?php
  require_once(__CA_LIB_DIR__."/Search/ObjectSearch.php");
?>
	<div class="row">
		<div class="col-sm-8">
      <?php print $this->render("pageFormat/searchBrowseHeader.php") ?>
		</div>
  </div>
  <div class="row">
    <div class="col-sm-8">
      <?php
          $o_search = new ObjectSearch();

          /* ultimately runs doSearch from lib/Search/SearchEngine.php, 
             which lists available options passed as second argument */
          $results = $o_search->search("*", ['limit' => 9]);

          while ($results->nextHit()) {
            print "<p><em>" . $results->get("ca_objects.preferred_labels.name") . "</em><br>";
            print "<strong>" . $results->get("ca_entity_labels.displayname") . "</strong></p>";
          }
      ?>
		</div>
	</div>