// Toggle Search type on Advanced Search form
window.addEventListener('DOMContentLoaded', (event) => {
  
  let buttons = document.querySelectorAll('.button--search-type');

  if(!(buttons)){
    return;
  }

  let searchForm = document.querySelector('.search-form');

  buttons.forEach( btn => {
    btn.addEventListener('click', event => {
      let clickedButton = event.target;
      let otherButton = clickedButton.nextElementSibling.classList.contains('button--search-type') ? clickedButton.nextElementSibling : clickedButton.previousElementSibling;
      
      let textInput = searchForm.querySelector('#_fulltext');
      let advancedInput = searchForm.querySelector('#advancedSearchInput');

      // if already active, return
      if (clickedButton.getAttribute('aria-pressed') === 'true'){
        return;
      }

      toggleAriaPressed(clickedButton);
      toggleAriaPressed(otherButton);

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