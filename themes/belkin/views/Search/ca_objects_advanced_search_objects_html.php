<?php
  $formData = $_POST;
?>
<div class="search-type-buttons accordion accordion--hidden">
  <div class="search-type-buttons-container">
    <button id="objectSearchButton" class="button button--search-type" aria-pressed="true">Object Search</button>
    <button id="collectionSearchButton" class="button button--search-type" aria-pressed="false">Collection Search</button>
    <div class="search-type-info">
      <img src="/pawtucket/themes/belkin/assets/graphics/questionmark.svg"/>
      <button class="button accordion-toggle" data-toggle-text="About Search Items">
        About Search Types
      </button>
    </div>
  </div>
  <div class="search-type-details accordion-details" style="height: 0px" aria-expanded="false">
    <p><strong>Objects</strong> include artworks and single items of archival material, such as a photograph, postcard or publication.</p>
    <p><strong>Collections</strong> include distinct groups of art and archival objects (i.e. Permanent, Outdoor and Archives).</p>
    <p>Note: within the Archives are groupings called fonds, series and files. Not all archival objects have been individually described.</p>
  </div>
</div>

<form class="search-form accordion accordion--hidden" action="/index.php/Search/objects" method="post" enctype="multipart/form-data" onSubmit="return handleCollectionsSubmit();">
  <div class="basic-search">
    <label for="_fulltext" class="formLabel visually-hidden">Keyword</label>
    <div class="basic-search-container">
      <input name="_fulltext[]" placeholder="Search Objects by Keyword" value="<?php echo $formData["_fulltext"][0] ? $formData["_fulltext"][0] : "";?>" class="search-input" id="_fulltext" rows="1" size="" type="text">
      <input name="_fulltext_label" value="Keywords" type="hidden">	
    </div>
    <button id="searchButton" class="button">Search</button>
  </div>
  <button class="button accordion-toggle" data-toggle-text="Advanced Search">Advanced Search</button>
  <script type="text/javascript">
    function handleCollectionsSubmit() {
      let form = document.querySelector('.search-form');
      if(form.action.includes('collection')){
        let keyword = encodeURIComponent(document.getElementById("_fulltext").value);
        let action = form.action;
        form.action += keyword;
      }
    }
  </script>
  <div class="advanced-search accordion-details" style="height: 0px" aria-expanded="false">
    <input type="hidden" name="_formName" value="caAdvancedSearch">
    <div class="advanced-search-fields">
      <div class="advanced-search-field">
        <label for="ca_objects.catalogue_destination.preferred_labels" class="formLabel">Collection Type</label>
        <div class="select-wrapper">
          <select class="search-input" name="ca_objects.catalogue_destination.preferred_labels" id="ca_objects.catalogue_destination.preferred_labels">
            <option value="">Select Collection Type</option>
            <option <?php if($formData["ca_objects_catalogue_destination_preferred_labels"] == "492"){echo "selected";}?> value="492">Archive</option>
            <option <?php if($formData["ca_objects_catalogue_destination_preferred_labels"] == "493"){echo "selected";}?> value="493">Artwork</option>
            <option <?php if($formData["ca_objects_catalogue_destination_preferred_labels"] == "494"){echo "selected";}?> value="494">Library</option>
          </select>
        </div>
        <input name="ca_objects.catalogue_destination.preferred_labels_label" value="Collection Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_entities.preferred_labels.displayname">Artist/Creator</label>
        <input class="search-input" name="ca_entities.preferred_labels.displayname" type="text" id="ca_entities.preferred_labels.displayname" value="<?php echo $formData["ca_entities_preferred_labels_displayname"] ? $formData["ca_entities_preferred_labels_displayname"] : "";?>"/>
        <input name="ca_entities.preferred_labels.displayname_label" value="Artist/Creator" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.preferred_labels.name">Title</label>
        <input class="search-input" name="ca_objects.preferred_labels.name" id="ca_objects.preferred_labels.name" type="text" value="<?php echo $formData["ca_objects_preferred_labels_name"] ? $formData["ca_objects_preferred_labels_name"] : "";?>">
        <input name="ca_objects.preferred_labels.name_label" value="Title" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.search_date[]">Date</label>
        <input class="search-input" name="ca_objects.search_date[]" id="ca_objects.search_date[]" type="text" value="<?php echo $formData["ca_objects_search_date"][0] ? $formData["ca_objects_search_date"][0] : "";?>">
        <input name="ca_objects.search_date_label" value="Date" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects.description[]">Description</label>
        <input class="search-input" name="ca_objects.description[]" id="ca_objects.description[]" type="text" value="<?php echo $formData["ca_objects_description"][0] ? $formData["ca_objects_description"][0] : "";?>">
        <input name="ca_objects.description_label" value="Description" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label for="ca_objects_object_category" class="formLabel">Type</label>
        <div class="select-wrapper">
          <select class="search-input" name="ca_objects_object_category" id="ca_objects_object_category">
            <option value="">Select Type</option>
            <option <?php if($formData["ca_objects_object_category"] == "408"){echo "selected";}?> value="408">Audio</option>
            <option <?php if($formData["ca_objects_object_category"] == "409"){echo "selected";}?> value="409">Film/Video</option>
            <option <?php if($formData["ca_objects_object_category"] == "410"){echo "selected";}?> value="410">Painting</option>
            <option <?php if($formData["ca_objects_object_category"] == "411"){echo "selected";}?> value="411">Performance</option>
            <option <?php if($formData["ca_objects_object_category"] == "412"){echo "selected";}?> value="412">Photography</option>
            <option <?php if($formData["ca_objects_object_category"] == "413"){echo "selected";}?> value="413">Sculpture/Installation/Object</option>
            <option <?php if($formData["ca_objects_object_category"] == "416"){echo "selected";}?> value="416">Textiles</option>
            <option <?php if($formData["ca_objects_object_category"] == "415"){echo "selected";}?> value="415">Texts</option>
            <option <?php if($formData["ca_objects_object_category"] == "414"){echo "selected";}?> value="414">Works on Paper</option>
          </select>
        </div>
        <input name="ca_objects_object_category_label" value="Type" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects_medium">Medium</label>
        <input class="search-input" name="ca_objects_medium" type="text" id="ca_objects_medium" value="<?php echo $formData["ca_objects_medium"] ? $formData["ca_objects_medium"] : "";?>">
        <input name="ca_objects.medium_label" value="Medium" type="hidden">
      </div>
      <div class="advanced-search-field">
        <label class="formLabel" for="ca_objects_idno[]">ID #</label>
        <input class="search-input" name="ca_objects_idno[]" type="text" id="ca_objects_idno[]" value="<?php echo $formData["ca_objects_idno"][0] ? $formData["ca_objects_idno"][0] : "";?>">
        <input name="ca_objects.idno_label" value="ID #" type="hidden">
      </div>
    </div>

    <input name="_advancedFormName" value="objects" type="hidden">
    <input name="_formElements" value="form|_fulltext|ca_objects.catalogue_destination.preferred_labels|ca_entities.preferred_labels.displayname|ca_objects.preferred_labels.name|ca_objects.search_date|ca_objects.description|ca_objects.idno|ca_objects.type_id|ca_objects_object_category|ca_objects.medium|/form" type="hidden">
    <input id="advancedSearchInput" name="_advanced" value="1" type="hidden">
  </div>
</form>
