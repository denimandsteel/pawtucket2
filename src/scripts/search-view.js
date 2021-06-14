window.addEventListener('DOMContentLoaded', (event) => {
  
  let controls = document.querySelector('#searchViewmode');
  let searchResults =  document.querySelector('#searchResults');
  if(!(controls && searchResults)){
    return;
  }

  let buttons = controls.querySelectorAll('.button');
  buttons.forEach( btn => {
    btn.addEventListener('click', event => {
      let clickedButton = event.target;
      let otherButton = clickedButton.nextElementSibling ? clickedButton.nextElementSibling : clickedButton.previousElementSibling;

      toggleAriaPressed(clickedButton);
      toggleAriaPressed(otherButton);
      searchResults.classList.toggle('search-results--grid');
    });
  });

  function toggleAriaPressed(element){
    let ariaPressed = ( element.getAttribute('aria-pressed') === 'true' );
    element.setAttribute('aria-pressed', !ariaPressed);
  }

});