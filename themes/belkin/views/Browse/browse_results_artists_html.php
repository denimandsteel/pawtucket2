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
 

  // should only do this for names - how can I differentiate between browse pages?
  $o_db = new Db();
  $q_entities = $o_db->query("select * from ca_entity_labels
                          where entity_id in (
                            select ca_entities.entity_id
                            from ca_entities
                            inner join ca_objects_x_entities on ca_entities.entity_id = ca_objects_x_entities.entity_id
                            inner join ca_attributes on ca_attributes.row_id = ca_objects_x_entities.object_id
                            inner join ca_attribute_values on ca_attributes.attribute_id = ca_attribute_values.attribute_id
                            where ca_objects_x_entities.type_id in (113, 121) -- artist,creator
                            group by ca_entities.entity_id
                          )
                          and is_preferred = true
                          order by surname asc");

			
$qrows = $q_entities->getAllRows();

$chunks = array_chunk(range('A','Z'),1); 
foreach($qrows as $row){
    foreach($chunks as $letters){
        if(in_array(strtoupper($row['surname'][0]), $letters)){  
            $letter_groups[implode($letters)][]=$row;  
            break; 
        }
    }
}
?>
<div class="fw-border-bottom">
  <nav class="letter-nav container">
    <a href="#A">A-F</a>
    <a href="#G">G-K</a>
    <a href="#L">L-P</a>
    <a href="#Q">Q-U</a>
    <a href="#V">V-Z</a>
  </nav>
</div>

<?php
  
  foreach($letter_groups as $letter => $names){
    print '<div class="fw-border-bottom" id="'.$letter.'">';
    print '<div class="letter-section container">';
    print '<h3 class="letter-heading">'.$letter.'</h3>';
    print '<ul class="letter-name-group">';
    foreach($names as $name){
      $fullname = $name["displayname"];
      print '<li><a href="/pawtucket/index.php/Detail/entities/'.$name["entity_id"].'">'.$fullname.'</a></li>';
    }
    print '</ul></div></div>';
  }


// ?>