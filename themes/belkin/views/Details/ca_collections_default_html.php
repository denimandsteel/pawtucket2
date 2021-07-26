<?php
	$t_item = $this->getVar("item");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
  $current_id = $t_item->get('ca_collections.collection_id');
?>
<article class="detail">
  <nav class="detail-nav">
    <!-- <a class="link link--back" href="">Results</a> -->
    <div class="detail-breadcrumb">
      {{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" / "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
    </div>
  </nav>

  <div class="detail-info">
    <div class="detail-info-intro">
      <div class="container">
        {{{<h1>^ca_collections.preferred_labels.name</h1>}}}

        <dl class="detail-info-list">
          <dt>Catalogue Number</dt>
					{{{<ifdef code="ca_collections.idno"><dd> ^ca_collections.idno </dd></ifdef>}}}
					{{{<ifnotdef code="ca_collections.idno"><dd>–</dd></ifnotdef>}}}
					<!-- {{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}} -->
				
          <!-- {{{<ifcount code="ca_entities" min="1" max="1"><dt>Artist/Creator</dt></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><dt>Artist/Creators</dt></ifcount>}}} -->
          <dt>Artist/Creator</dt>
					{{{<dd><unit relativeTo="ca_entities_x_collections" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></dd>}}}
					
          <dt>Date</dt>
          {{{<ifdef code="ca_collections.search_date">
            <dd><unit delimiter=", ">^ca_collections.search_date</unit></dd>
          </ifdef>
          <ifnotdef code="ca_collections.search_date">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Identifier</dt>
          {{{<ifdef code="ca_collections.alt_idno">
            <dd>^ca_collections.alt_idno</dd>
          </ifdef>
          <ifnotdef code="ca_collections.alt_idno">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Level of Description</dt>
          {{{<ifdef code="ca_collections.level_description">
            <dd>^ca_collections.level_description</dd>
          </ifdef>
          <ifnotdef code="ca_collections.level_description">
            <dd>–</dd>
          </ifnotdef>}}} 
    
        </dl>
      </div>
    </div>
        
    {{{<ifdef code="ca_collections.RAD_scopecontent">
    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Scope & Content</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
					 <p class='unit detail-info-paragraph'>^ca_collections.RAD_scopecontent</p>
        </div>
      </div>
    </div>
    </ifdef>}}}

    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Physical Description</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">
        <!-- Is description different than phyiscal extent?? -->
          <dt>Physical Extent</dt>
          {{{<ifdef code="ca_collections.RAD_extent">
            <dd>^ca_collections.RAD_extent</dd>
          </ifdef>
          <ifnotdef code="ca_collections.RAD_extent">
            <dd>–</dd>
          </ifnotdef>}}} 

          <dt>Material Type</dt>
          {{{<ifdef code="ca_collections.gmd">
            <dd><unit delimiter=", ">^ca_collections.gmd</unit></dd>
          </ifdef>
          <ifnotdef code="ca_collections.gmd">
            <dd>–</dd>
          </ifnotdef>}}} 

        </dl>
      </div>
    </div>

    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Navigate Fonds</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
            <div id="hierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
            <script>
              $(document).ready(function(){
                $('#hierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $vn_top_level_collection_id, 'current_id' => $current_id ), array('useQueryString' => true)); ?>"); 
              })
            </script>
          </div>
      </div>
    </div>
    
    <div class="detail-actions fw-border-top">
      <div class="container">
        <button class="button button--catalogue "><?php print caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary')); ?></button>
        <button class="button button--catalogue ">Contact us</button>
      </div>
    </div>
</article>
