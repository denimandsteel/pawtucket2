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
        <p>With over 5,000 artworks and 20,000 archival records, our collections focus on the Canadian avant-garde of the 1960s and 1970s, the international network developed at that time, and its role in the art of today.</p>
        <div class="collections-intro-tips">
          <a class="link" href="https://belkin.ubc.ca/collections/">More About the Collections</a>
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

  <?php
    $va_access_values = caGetUserAccessValues($this->request);
    $o_config 	= $this->getVar("config");
    $vs_table 			= "ca_objects";
    $vs_pk				= "object_id";
    $t_list_item = new ca_list_items();
    $t_set = new ca_sets();
    
    // get all sets with Access 'Public'
    $all_sets = $t_set->getSets(array('checkAccess' => 1));
    $grouped_sets = array();
    foreach($all_sets as $set){
      $set_code = $set[1]["set_code"];
      $set_name = $set[1]["name"];
      
      $set_data = explode(" - ", $set_name);
      $set_group = $set_data[0];
      $set_curator_names = array_slice($set_data, 1, -1);
      $set_curator_name = implode(" ", $set_curator_names);

      $set_keyword = end($set_data);

      if(preg_match("/^Home/", $set_group)){
        $grouped_sets[$set_curator_name]["sets"][$set_keyword] = $set[1];
      }

      if(preg_match("/^Home Bio/", $set_group)){
        $current_set = new ca_sets();
			  $current_set->load($set[1]["set_id"]);

        $bio = $current_set->get('set_description', array('returnAsArray' => true, 'convertLineBreaks' => true));

        // create array of curator info
        $curator = (object) [
          'name' => $set_curator_name,
          'bio' => $bio[0],
          'bio_extended' => $bio[1]
        ];
         
        $grouped_sets[$set_curator_name]["curator"] = $curator;
      }

    }
    print '<select class="" name="ca_objects.type_id" id="exploreCurator">';
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
        <button id="extend-bio" class="link">[more]</button>
        <p class="frontpage-explore-bio-extended hidden"><?php echo $set_group["curator"]->bio_extended ?></p>
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
      <div class="frontpage-explore-group"> 
        <div class="section filters fw-border-top fw-border-bottom">
          <div class="filter container">
            <ul class="filter-list">
            <?php 
              $i = 1;
              foreach($set_group["sets"] as $set_name => $set){ ?>
              <li class="filter-item button toggle"><?php echo $set_name ?></li>
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
              
              $vs_idno = $qr_res->get("ca_objects.idno");
              $vs_label_detail 	= $qr_res->get("{$vs_table}.preferred_labels");
              $vs_typecode = "";
              $vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'medium', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
              $web_notice = $qr_res->get("ca_objects.web_notice");

              if(!$vs_image){
                if ($vs_table == 'ca_objects') {
                  $vs_image = "<div class='no-image-available'><span>No Image<br>Available</span></div>";
                }
              }
    
              if($web_notice) {
                $vs_image = '<div class="sensitive-content"><img src="/pawtucket/themes/belkin/assets/graphics/sensitive-content.jpg"/><span>Access Record<br>To View</span></div>';
              }
    
              $vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
            
              $vs_add_to_set_link = "";
              if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
                $vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
              }
    
              $vs_artist_display_name = $qr_res->get("ca_entities.preferred_labels.displayname", array('restrictToRelationshipTypes' => ['creator', 'artist'], 'delimiter' => '<br>'));
          
              if($vs_artist_display_name ){
                $vs_artist = $vs_artist_display_name;
              }else {
                $vs_artist = "<div class='text-center'>-</div>";
              }
              $vs_date = $qr_res->get("ca_objects.pub_date", array('delimiter' => ' '));
    
              $vs_collection = $qr_res->get("ca_collections.preferred_labels", array('delimiter' => ', ', 'checkAccess' => $va_access_values,'returnAsArray' => true))[0];
    
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
                  {$vs_label_detail}
                </div>
                <div class='result-object-year'>
                  {$vs_date}
                </div>         
                <div class='result-object-idno'>
                  {$vs_idno}
                </div>          
                <div class='result-object-collection'>
                  {$vs_collection}
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

    </div>
  <?php 
  }
  ?>
  </article>





    