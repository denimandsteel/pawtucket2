window.addEventListener('DOMContentLoaded', (event) => {
  
  let contentwarning = document.querySelector('.button--sensitive');

  if(!contentwarning){
    return;
  }
  contentwarning.addEventListener('click', (event) => {
    event.preventDefault();
    const contentWrapper = event.target.closest('.sensitive-content-wrapper');
    contentWrapper.classList.add('hidden');
  })
});