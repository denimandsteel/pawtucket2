<form class="search-form" action="/pawtucket/index.php/Search/objects" method="post">
  <div class="basic-search">
    <label for="_fulltext" class="formLabel visually-hidden">Keyword</label>
    <div class="basic-search-container">
      <input name="_fulltext[]" placeholder="Search by Keyword" value="" class="search-input" id="_fulltext" rows="1" size="" type="text">
      <input name="_fulltext_label" value="Keywords" type="hidden">	
      <select class="basic-search-select">
        <option value="">All Fields</option>
        <option value="artist">Artist/Creator</option>
        <option value="title">Title</option>
        <option value="date">Date</option>
        <option value="medium">Medium</option>
      </select>
    </div>
    <button class="button">Search</button>
  </div>
  <button class="button button--toggle">Advanced Search</button>

  <div class="advanced-search" aria-expanded="false">
    <input type="hidden" name="_formName" value="caAdvancedSearch">
    <input name="form_timestamp" value="1623864107" type="hidden">
    <div class="advanced-search-fields">
      <div class="advanced-search-field">
        <label class="formLabel" >Collection</label>
        <input class="search-input" name="ca_collections.preferred_labels" type="text" id="ca_collections_preferred_labels"/>
        <input name="ca_collections.preferred_labels_label" value="Collection names (from related collections)" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel">Artist/Creator </label>
        <input class="search-input" name="ca_entities.preferred_labels" type="text" id="ca_entities_preferred_labels"/>
        <input name="ca_entities.preferred_labels_label" value="Entity names (from related entities)" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.search_date">Title</label>
          <input name="ca_objects.preferred_labels.name" id="ca_objects.preferred_labels.name" type="text">
          <input name="ca_objects.preferred_labels.name_label" value="Name" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.search_date">Date</label>
          <input name="ca_objects.search_date" id="ca_objects.search_date" value="" maxlength="255" class="dateBg" type="text">
          <input name="ca_objects.date_created_label" value="Date" type="hidden">
      </div>
      <!-- test this -->
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.description">Description</label>
          <input name="ca_objects.description" id="ca_objects.search_date" value="" maxlength="255"  type="text">
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
        <label for="ca_objects.date.dates_value[]" class="formLabel" data-content="Search records of a particular date or date range." data-original-title="" title="">Date range <i>(e.g. 1970-1979)</i></label>
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.idno[]">ID #</label>
        <input class="search-input" name="ca_objects.idno[]" type="text"  value="" id="ca_objects_idno[]">
        <input name="ca_objects.idno_label" value="Object identifier" type="hidden">
      </div>
    </div>

    <input name="_advancedFormName" value="objects" type="hidden">
    <input name="_formElements" value="form|_fulltext|ca_objects.preferred_labels.name|ca_objects.idno|ca_objects.type_id|ca_collections.preferred_labels|/form" type="hidden">
    <input name="_advanced" value="1" type="hidden">
  </div>
</form>