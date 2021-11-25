 <?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
			$vs_name = $t_item->get($ps_table.".preferred_labels.name");
			$vs_idno = $t_item->get($ps_table.".idno");
			$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
		}
	}
?>
<div class="container"><div class="col-sm-12">
	<h1>Contact Us</h1>
  <p>For questions and comments about the collections, or if you have noticed information that is incorrect, incomplete or may require further discussion, please contact us. <a href="mailto:belkin.collections@ubc.ca"><strong>belkin.collections@ubc.ca</strong></a></p>
  <h2>Content Notice</h2>
  <p>Because the Morris and Helen Belkin Gallery has been a collecting institution since 1948, some content on the Belkin Collections website may be upsetting: original records can reflect the prejudices and attitudes of their historical periods and database descriptions and metadata can reflect biased views. We are working through our records to create descriptions that diminish possible harm. If a record is flagged, it will be reviewed, contextualized and updated, although outdated language may be retained in metadata if it is copied directly from an original work, such as from a title or quote. </p>
  <h2>Take Down Requests</h2>
  <p>Due to the nature of archival material, we are not always able to identify potential consequences of publishing a photograph or text. If you appear in a record, you have the right to request this information be removed from publication. Please note that we may ask further questions to better understand the request.</p>
  <h2>Contact Form</h2>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
	if($pn_id && $t_item->getPrimaryKey()){
?>
		<div class="row">
			<div class="col-sm-12">
				<p><b>Title: </b><?php print $vs_name; ?>
				<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
				</p>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<hr/><br/><br/>
	
			</div>
		</div>
<?php
	}
?>
    <div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
      <label for="name">Name</label>
      <input type="text" class="form-control input-sm" aria-label="enter name" id="name" name="name" value="{{{name}}}">
    </div>
    <div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
      <label for="email">Email address</label>
      <input type="text" class="form-control input-sm" id="email" name="email" value="{{{email}}}">
    </div>
    <div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
      <label for="security">Security Question</label>
      <div class='row'>
          <span class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </span>
          <input name="security" value="" id="security" type="text" class="form-control input-sm" />
      </div><!--end row-->	
    </div><!-- end form-group -->
    <div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
      <label for="message">Message</label>
      <textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
    </div>
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
        	};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>


			<div class="row">
				<div class="col-sm-12 col-md-offset-1 col-md-10">
					<div class='form-group<?php print (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
						<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
					</div>
				</div>
			</div><!-- end row -->
<?php
	}
?>
		<div class="form-group">
			<button type="submit" class="button">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
	
</div><!-- end col --></div><!-- end row -->
