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

  <div class="advanced-search accordion-details" style="height: 0px" aria-expanded="false">
    <input type="hidden" name="_formName" value="caAdvancedSearch">
    <div class="advanced-search-fields">
      <div class="advanced-search-field">
        <label for="ca_objects.catalogue_destination.preferred_labels" class="formLabel">Collection Type</label>
        <select class="search-input" name="ca_objects.catalogue_destination.preferred_labels" class="" id="ca_objects.catalogue_destination.preferred_labels">
          <option value="">Select Collection Type</option>
          <option value="492">Archive</option>
          <option value="493">Artwork</option>
          <option value="494">Library</option>
        </select>
        <input name="ca_objects.catalogue_destination.preferred_labels_label" value="Collection Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_entities.preferred_labels.displayname">Artist/Creator</label>
        <input class="search-input" name="ca_entities.preferred_labels.displayname" type="text" id="ca_entities.preferred_labels.displayname"/>
        <input name="ca_entities.preferred_labels.displayname_label" value="Artist/Creator" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.preferred_labels.name">Title</label>
        <input name="ca_objects.preferred_labels.name" id="ca_objects.preferred_labels.name" type="text">
        <input name="ca_objects.preferred_labels.name_label" value="Title" type="hidden">
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
        <label for="ca_objects_object_category" class="formLabel">Type</label>
        <select class="search-input" name="ca_objects_object_category" id="ca_objects_object_category">
          <option value="">Select Type</option>
          <option value="408">Audio</option>
          <option value="409">Film/Video</option>
          <option value="410">Painting</option>
          <option value="411">Performance</option>
          <option value="412">Photography</option>
          <option value="413">Sculpture/Installation/Object</option>
          <option value="416">Textiles</option>
          <option value="415">Texts</option>
          <option value="414">Works on Paper</option>
        </select>
        <input name="ca_objects_object_category_label" value="Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.medium">Medium</label>
        <input class="search-input" name="ca_objects.medium" type="text" id="ca_objects.medium">
        <input name="ca_objects.medium_label" value="Medium" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.idno[]">ID #</label>
        <input class="search-input" name="ca_objects.idno[]" type="text"  value="" id="ca_objects_idno[]">
        <input name="ca_objects.idno_label" value="ID #" type="hidden">
      </div>
    </div>

    <input name="_advancedFormName" value="objects" type="hidden">
    <input name="_formElements" value="form|_fulltext|ca_objects.catalogue_destination.preferred_labels|ca_entities.preferred_labels.displayname|ca_objects.preferred_labels.name|ca_objects.search_date|ca_objects.description|ca_objects.idno|ca_objects.type_id|ca_objects_object_category|ca_objects.medium|/form" type="hidden">
    <input name="_advanced" value="1" type="hidden">
  </div>
</form>
