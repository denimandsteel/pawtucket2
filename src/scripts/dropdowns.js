window.addEventListener('DOMContentLoaded', (event) => {

  const dropdowns = Array.from(document.querySelectorAll('.dropdown'));

  if(!dropdowns){
    return;
  }

  dropdowns.forEach( (dropdown) => {
    const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
    const dropdownList = dropdown.querySelector('.dropdown-list');
    //add event listener to button
    dropdownToggle.addEventListener('click', (event)=> {
      dropdownList.classList.toggle('hidden');
      event.preventDefault();
    })
  })

});
