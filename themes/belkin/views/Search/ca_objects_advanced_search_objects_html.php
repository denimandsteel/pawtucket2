<form class="search-form accordion accordion--hidden" action="/pawtucket/index.php/Search/objects" method="post" enctype="multipart/form-data">
  <div class="basic-search">
    <label for="_fulltext" class="formLabel visually-hidden">Keyword</label>
    <div class="basic-search-container">
      <input name="_fulltext[]" placeholder="Search by Keyword" value="" class="search-input" id="_fulltext" rows="1" size="" type="text">
      <input name="_fulltext_label" value="Keywords" type="hidden">	
      <!-- <select class="basic-search-select">
        <option value="">All Fields</option>
        <option value="artist">Artist/Creator</option>
        <option value="title">Title</option>
        <option value="date">Date</option>
        <option value="medium">Medium</option>
      </select> -->
    </div>
    <button class="button">Search</button>
  </div>
  <button class="button accordion-toggle">Advanced Search</button>

  <div class="advanced-search accordion-details"  style="height: 0px" aria-expanded="false">
    <input type="hidden" name="_formName" value="caAdvancedSearch">
    <div class="advanced-search-fields">
      <div class="advanced-search-field">
        <label for="ca_objects_catalogue_destination.preferred_labels" class="formLabel">Catalogue</label>
        <select class="search-input" name="ca_objects_catalogue_destination.preferred_labels" class="" id="ca_objects_catalogue_destination.preferred_labels">
          <option value="">Select Catalogue</option>
          <option value="Archive">Archive</option>
          <option value="Artwork">Artwork</option>
          <option value="Library">Library</option>
        </select>
        <input name="ca_objects.catalogue_destination.preferred_labels_label" value="Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_entities.preferred_labels.displayname">Artist/Creator</label>
        <input class="search-input" name="ca_entities.preferred_labels.displayname" type="text" id="ca_entities.preferred_labels.displayname"/>
        <input name="ca_entities.preferred_labels.displayname_label" value="Display name (from related entities)" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.preferred_labels.name">Title</label>
        <input name="ca_objects.preferred_labels.name" id="ca_objects.preferred_labels.name" type="text">
        <input name="ca_objects.preferred_labels.name_label" value="Name" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.search_date[]">Date</label>
        <input name="ca_objects.search_date[]" id="ca_objects.search_date[]" type="text">
        <input name="ca_objects.search_date_label" value="Date" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.description[]">Description</label>
        <input name="ca_objects.description[]" id="ca_objects.description[]" type="text">
        <input name="ca_objects.description_label" value="Description" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label for="ca_objects_type_id" class="formLabel">Type</label>
        <select class="search-input" name="ca_objects.type_id" class="" id="ca_objects_type_id">
          <option value="">Select Type</option>
          <option value="23">Audio</option>
          <option value="25">Digital Media</option>
          <option value="27">Item</option>
          <option value="24">Moving Image</option>
          <option value="26">Publication</option>
        </select>
        <input name="ca_objects.type_id_label" value="Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.medium">Medium</label>
        <input class="search-input" name="ca_objects.medium" type="text" id="ca_objects.medium">
        <input name="ca_objects.medium_label" type="hidden">
      </div>
      <!-- <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.level_description">Level of Description</label>
        <input class="search-input" name="ca_objects.level_description" type="text"  value="" id="ca_objects_level_description">
        <input name="ca_objects.level_description" value="" type="hidden">
      </div> -->
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.idno[]">ID #</label>
        <input class="search-input" name="ca_objects.idno[]" type="text"  value="" id="ca_objects.idno[]">
        <input name="ca_objects.idno_label" value="Object identifier" type="hidden">
      </div>
    </div>

    <input name="_advancedFormName" value="objects" type="hidden">
    <input name="_formElements" value="form|_fulltext|ca_objects_catalogue_destination|ca_entities.preferred_labels.displayname|ca_objects.preferred_labels.name|ca_objects.search_date|ca_objects.description|ca_objects.idno|ca_objects.type_id|ca_objects.medium|/form" type="hidden">
    <input name="_advanced" value="1" type="hidden">
  </div>
</form>
