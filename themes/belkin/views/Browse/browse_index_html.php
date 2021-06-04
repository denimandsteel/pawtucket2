<?php
  require_once(__CA_LIB_DIR__."/Search/ObjectSearch.php");
?>

<div class="row">
  <div class="col-sm-8">
    <?php print $this->render("pageFormat/searchBrowseHeader.php") ?>
  </div>
</div>
<div class="row">
  <div class="container">
  <?php
    $o_search = new ObjectSearch();

    $results = $o_search->search("*", ['sort' => 'ca_objects.preferred_labels.name']);
    $char;

    while ($results->nextHit()) {
      $current_char = substr($results->get("ca_objects.preferred_labels.name"), 0, 1);
      $id = $results->get("ca_objects.{$vs_pk}");

      if (ctype_alpha($current_char) && !strcasecmp($current_char, $char) == 0) {
        print "<h2>" . strtoupper($current_char) . "</h2>";
        $char = $current_char;
      }
      if (ctype_alpha($current_char)) {
        print "<p>" . caDetailLink($this->request, $results->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $results->get("ca_objects.object_id")) . "</p>";
      }
    }
  ?>
  </div>
</div>