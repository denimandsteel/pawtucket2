      <h1>Online Collections</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
      <h2 <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Search + Explore"), "", "", "Front", "index"); ?></h2>
      <h2 <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><a href="/ca/pawtucket/index.php/browse/objects">Browse</a></h2>