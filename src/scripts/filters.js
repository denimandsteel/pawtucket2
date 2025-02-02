window.addEventListener('DOMContentLoaded', (event) => {

  // Get relevant elements and collections
  const filter = document.querySelector('#filterGroups');
  if(!filter){
    return;
  };
  
  const tablist = filter.querySelector('.filter-header');
  const moreResults = filter.querySelector('.filter-more-results');
  const tabs = Array.from(tablist.querySelectorAll('.filter-tab'));
  const panels = filter.querySelectorAll('.filter-group');
  moreResults.style.display = 'none';



  
  const switchTab = (oldTab, newTab) => {
    newTab.focus();
    // Make the active tab focusable by the user (Tab key)
    newTab.removeAttribute('tabindex');
    // Set the selected state
    newTab.setAttribute('aria-selected', 'true');
    oldTab.removeAttribute('aria-selected');
    oldTab.setAttribute('tabindex', '-1');
    //to deal with jQuery for more results element
    moreResults.style.display = 'none';
    panels.forEach(panel => {
      panel.style.display = 'block';
    });

    // Get the indices of the new and old tabs to find the correct
    // tab panels to show and hide
    let index = tabs.indexOf(newTab);
    let oldIndex = tabs.indexOf(oldTab);
    panels[oldIndex].hidden = true;
    panels[index].hidden = false;
  }
  
  tabs.forEach((tab, i) => {
    
    // Handle clicking of tabs for mouse users
    tab.addEventListener('click', e => {
      e.preventDefault();
      let currentTab = tablist.querySelector('[aria-selected]');
      if (e.currentTarget !== currentTab) {
        switchTab(currentTab, e.currentTarget);
      }
    });
    
    // Handle keydown events for keyboard users
    tab.addEventListener('keydown', e => {
      // Get the index of the current tab in the tabs node list
      let index = tabs.indexOf(e.currentTarget);
      // Work out which key the user is pressing and
      // Calculate the new tab's index where appropriate
      let dir = e.which === 37 ? index - 1 : e.which === 39 ? index + 1 : e.which === 40 ? 'down' : null;
      if (dir !== null) {
        e.preventDefault();
        // If the down key is pressed, move focus to the open panel,
        // otherwise switch to the adjacent tab
        dir === 'down' ? panels[i].focus() : tabs[dir] ? switchTab(e.currentTarget, tabs[dir]) : void 0;
      }
    });
  });
  
  // Add tab panel semantics and hide them all
  panels.forEach( (panel, i) => {
    panel.hidden = true; 
  });
  
  // Initially activate the first tab and reveal the first tab panel
  tabs[0].removeAttribute('tabindex');
  tabs[0].setAttribute('aria-selected', 'true');
  panels[0].hidden = false;
});
// });