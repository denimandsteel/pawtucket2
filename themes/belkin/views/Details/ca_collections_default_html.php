<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

?>



					<!-- {{{<ifdef code="ca_collections.description"><label>About</label>^ca_collections.description<br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}} -->


					<!-- {{{<ifcount code="ca_collections.related" min="1" max="1"><label>Related collection</label></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><label>Related collections</label></ifcount>}}}
					{{{<unit relativeTo="ca_collections_x_collections"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
					

					{{{<ifcount code="ca_occurrences" min="1" max="1"><label>Related occurrence</label></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><label>Related occurrences</label></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_collections"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}

 -->


<article class="detail">
  <nav class="detail-nav">
    <a class="link link--back" href="">Results</a>
    <div class="detail-breadcrumb">
      {{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
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
				
          {{{<ifcount code="ca_entities" min="1" max="1"><dt>Artist/Creator</dt></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><dt>Artist/Creators</dt></ifcount>}}}
					{{{<dd><unit relativeTo="ca_entities_x_collections"><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></dd>}}}
					
          <dt>Date</dt>
          {{{<ifdef code="ca_collections.search_date">
            <dd>^ca_collections.search_date</dd>
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
          <p class="accordion-details" aria-expanded="true">
					 <div class='unit detail-info-paragraph'>^ca_collections.RAD_scopecontent</div>
          </p>
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

          <dt>GMD</dt>
          {{{<ifdef code="ca_collections.gmd">
            <dd>^ca_collections.gmd</dd>
          </ifdef>
          <ifnotdef code="ca_collections.gmd">
            <dd>–</dd>
          </ifnotdef>}}} 

        </dl>
      </div>
    </div>

    <!-- <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Collection History</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
        <dl class="detail-info-list accordion-details" aria-expanded="true">

          <dt>Collection</dt>
          {{{
          <ifdef code="ca_collections">
            <unit relativeTo="ca_collections" delimiter="<br/>"><l><dd>^ca_collections.preferred_labels.name</dd></l></unit>
          </ifdef>
          <ifnotdef code="ca_collections"><dd>–</dd></ifnotdef>
        }}}

          <dt>Credit Line</dt>
          {{{<ifdef code="ca_collections.credit_line">
            <dd>^ca_collections.credit_line</dd>
          </ifdef>
          <ifnotdef code="ca_collections.credit_line">
            <dd>–</dd>
          </ifnotdef>}}}
  
  
          <dt>Related exhibition</dt>
          {{{
            <ifdef code="ca_occurences">
              <unit relativeTo="ca_occurences_x_collections" delimiter="<br/>"><l><dd>^ca_occurences.preferred_labels.name</dd></l></unit>
            </ifdef>
            <ifnotdef code="ca_occurences"><dd>–</dd></ifnotdef>
          }}}

          <!-- TODO: figure out what this actually is -->
          <!-- <dt>Exhibition History</dt>
          {{{
            <ifdef code="^ca_occurences.preferred_labels.name"><unit relativeTo="ca_occurences" delimiter="<br/>"><l><dd>^ca_occurences.preferred_labels.name</dd></l></unit></ifdef>
            <ifnotdef code="^ca_occurences.preferred_labels.name"><dd>–</dd></ifnotdef>
          }}} 
        </dl>
      </div>
    </div> -->

    <div class="detail-info-box fw-border-top accordion">
      <div class="container">
        <div class="detail-info-box-header">
          <h2>Navigate Fonds</h2>
          <button class="button accordion-toggle">Hide</button>
        </div>
          <div class="accordion-details" aria-expanded="true">
            <div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
            <script>
              $(document).ready(function(){
                $('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
              })
            </script>
          </div>
      </div>
    </div>
    
    <div class="detail-actions fw-border-top">
      <div class="container">
        <button class="button button--catalogue "><?php print caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary')); ?></button>
        <button class="button button--catalogue ">Contact us</button>
        <button class="button button--catalogue "><?php print $this->getVar("shareLink"); ?></button>
      </div>
    </div>

    <!--  -->
</article>
