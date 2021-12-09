// Toggle Search type on Advanced Search form
window.addEventListener('DOMContentLoaded', (event) => {
  
  let buttons = document.querySelectorAll('.button--search-type');

  if(buttons.length < 1){
    return;
  }

  let searchForm = document.querySelector('.search-form');
  let textInput = searchForm.querySelector('#_fulltext');
  let advancedInput = searchForm.querySelector('#advancedSearchInput');
  
  let pageWrapper = document.getElementById("pageArea");
  if (pageWrapper.classList.contains('ca_collections')){ // if collections search
    searchForm.setAttribute('action', "/pawtucket/index.php/Search/collections/search/");
    textInput.placeholder = "Search Collections by Keyword";
    advancedInput.value = 0;
    toggleAriaPressed(buttons[0]);
    toggleAriaPressed(buttons[1]);
    searchForm.classList.toggle('collection-search');

  }


  buttons.forEach( btn => {
    btn.addEventListener('click', event => {
      let clickedButton = event.target;
      let otherButton = clickedButton.nextElementSibling.classList.contains('button--search-type') ? clickedButton.nextElementSibling : clickedButton.previousElementSibling;
      
      // if already active, return
      if (clickedButton.getAttribute('aria-pressed') === 'true'){
        return;
      }

      toggleAriaPressed(clickedButton);
      toggleAriaPressed(otherButton);
      searchForm.classList.toggle('collection-search');


      if (clickedButton.id == 'collectionSearchButton'){
        searchForm.setAttribute('action', "/pawtucket/index.php/Search/collections/search/");
        textInput.placeholder = "Search Collections by Keyword";
        advancedInput.value = 0;

        // let submitButton = 
      }
      else {
        searchForm.setAttribute('action', "/pawtucket/index.php/Search/objects");
        textInput.placeholder = "Search Objects by Keyword";
        advancedInput.value = 1;
      }
    });
  });

  function toggleAriaPressed(element){
    let ariaPressed = ( element.getAttribute('aria-pressed') === 'true' );
    element.setAttribute('aria-pressed', !ariaPressed);
  }

});