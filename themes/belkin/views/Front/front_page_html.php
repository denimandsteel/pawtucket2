<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
		// print $this->render("Front/featured_set_slideshow_html.php");

?>
  <div class="frontpage collections">
    <div class="container">
      <h1>Online Collections</h1>
      <div class="collections-intro">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
        <div class="collections-intro-tips">
          <a class="link" href="">More About the Collections</a>
          <a class="link" href="">Search Tips</a>
        </div>
      </div>
      <nav>
        <ul class="collections-nav">
          <li><a class="active" href="/pawtucket">Search + Explore</a></li>
          <li><a href="/pawtucket/index.php/Browse/entities">Browse</a></li>
        </ul>
      </nav>
    </div>

  <article class="search frontpage-search fw-border-top">
    <div class="container">
      <?php 
    include( dirname(__FILE__, 2).'/Search/ca_objects_advanced_search_objects_html.php');
      ?>
      
    </div>
  </article>

  <article id="explore" class="frontpage-explore fw-border-top fw-border-bottom">
    <div class="frontpage-explore-header container">
      <h2>Explore the Belkin Collection</h2><span> with Five Words from: </span> 
      <select class="" name="ca_objects.type_id" id="exploreCurator">

  <?php
    $va_access_values = caGetUserAccessValues($this->request);
    $o_config 	= $this->getVar("config");
    $vs_table 			= "ca_objects";
    $vs_pk				= "object_id";
    $t_list_item = new ca_list_items();
    $t_set = new ca_sets();
    
    // get all sets
    $all_sets = $t_set->getSets();
    // separate sets into arrays per Author *set_1_1 etc
    $grouped_sets = array();
    foreach($all_sets as $set){
      $set_name = $set[1]["set_code"];
      $set_indices = explode("_", $set_name);
      $set_group = $set_indices[1];
      $set_index = $set_indices[2];
      $grouped_sets[$set_group]["sets"][$set_index] = $set[1];

      // if group doesn't have name/bio/extended, add it
      if(!isset($grouped_sets[$set_group]["curator"])){
        // create array of curator info
        $curator = (object) [
          'name' => $o_config->get("set_". $set_group . "_name"),
          'bio' => $o_config->get("set_". $set_group . "_bio"),
          'bio_extended' => $o_config->get("set_". $set_group . "_bio_extended")
        ];
         
        $grouped_sets[$set_group]["curator"] = $curator;
      }
    }
    $index = 0;
    foreach($grouped_sets as $set_group){ 

      ?>
          <option value="<?php echo $index ?>"><?php echo $set_group["curator"]->name ?></option>
    <?php 
      $index++;
    } 
    ?>
        </select>
        <div class="frontpage-explore-bios">
    <?php 
    foreach($grouped_sets as $set_group){ ?>
      <div class="frontpage-explore-bio"><p><?php echo $set_group["curator"]->bio ?></p>
      <?php 
      if(isset($set_group["curator"]->bio_extended) ){ ?>
        <a href>[more]</a>
        <p class="frontpage-explore-bio-extended"><?php echo $set_group["curator"]->bio_extended ?></p>
        <?php 
      }?>
      </div>
      <?php 
    } 
    ?>
        </div>
    </div>

    <?php 
    foreach($grouped_sets as $set_group){ ?>

    <div class="section filters fw-border-top fw-border-bottom">
      <div class="filter container">
        <ul class="filter-list">
        <?php 
          $i = 1;
          foreach($set_group["sets"] as $set){ ?>
          <li class="filter-item button toggle <?php if($i == 1) { echo ' active';}  ?>"><?php echo $set["name"] ?></li>
          <?php 
            $i++;
          } 
          ?>
        </ul>
      </div>
    </div>

<!-- results -->
    <div class="container results-container">
    <?php
    foreach($set_group["sets"] as $set){ 
      $vs_set_code = $set["set_code"];
      if($vs_set_code){
        $t_set->load(array('set_code' => $vs_set_code));
        // $vn_set_id = $t_set->get("set_id");
        if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
          $va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());

          $qr_res = caMakeSearchResult('ca_objects', $va_set_item_ids);
        }		
      }
      ?>
        <div class="result-objects result-objects--grid">

      <?php
      
      if ($qr_res) {
        while ($qr_res->nextHit()) {
          $vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
          if($vn_id == $vn_row_id){
            $vb_row_id_loaded = true;
          }
          
          $vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
          $vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
          $vs_thumbnail = "";
          $vs_type_placeholder = "";
          $vs_typecode = "";
          $vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'medium', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
        
          if(!$vs_image){
            if ($vs_table == 'ca_objects') {
              $t_list_item->load($qr_res->get("type_id"));
              $vs_typecode = $t_list_item->get("idno");
              if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
                $vs_image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
              }else{
                $vs_image = $vs_default_placeholder_tag;
              }
            }else{
              $vs_image = $vs_default_placeholder_tag;
            }
          }
          $vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
        
          $vs_add_to_set_link = "";
          if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
            $vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
          }

          $vs_artist_detail_link = caDetailLink($this->request, $qr_res->get("ca_entities.preferred_labels.displayname"), '', $vs_table, $vn_id);
          $vs_artist = $qr_res->get("ca_entities.preferred_labels.displayname", array('restrictToRelationshipTypes' => ['creator'], 'delimiter' => ' '));
          
          $vs_date = $qr_res->get("ca_objects.pub_date", array('delimiter' => ' '));

          $vs_collection = $qr_res->get("ca_collections.preferred_labels", array('delimiter' => ', ', 'checkAccess' => $va_access_values));
          $vs_collection_detail_link = caDetailLink($this->request, $qr_res->get("ca_collections.preferred_labels"), '', $vs_table, $vn_id);

          $vs_catalogue= $qr_res->get("ca_objects.catalogue_destination.preferred_labels", array("convertCodesToDisplayText" => 1));


          $vs_result_output = "
          <div class='result-object'>
            <div class='result-object-image'>
              {$vs_rep_detail_link}
            </div>
            <div class='result-object-catalogue fw-border-bottom'>
              {$vs_catalogue}
            </div>
            <div class='result-object-artist'>
              {$vs_artist}
            </div>
            <div class='result-object-title'>
              {$vs_label_detail_link}
            </div>
            <div class='result-object-idno'>
              {$vs_date}
            </div>         
            <div class='result-object-year'>
              {$vs_idno_detail_link}
            </div>          
            <div class='result-object-collection'>
              {$vs_collection_detail_link}
            </div>   
            
          </div>";
          print $vs_result_output;
        }				
        $vn_results_output++;
      }
    ?>
      </div>

    <?php 
    } 
    ?>
    </div>
  <?php 
  }
  ?>
  </article>





    