window.addEventListener('DOMContentLoaded', (event) => {
  
  let accordions = Array.from(document.querySelectorAll('.accordion'));
  if(!accordions.length){
    return;
  }
  // add event listeners to expand buttons
  let expandBtns = document.querySelectorAll('.accordion-toggle');

  expandBtns.forEach( btn => {
    btn.addEventListener('click', event => {
      let accordionItem = event.target.closest('.accordion');
      let detailsSection = accordionItem.querySelector('.accordion-details');
      let isCollapsed = ( detailsSection.getAttribute('aria-expanded') === "false" );
      if(isCollapsed){
        expandSection(detailsSection);
      }
      else {
        collapseSection(detailsSection);
      }
    })
  })
});


// modified from https://css-tricks.com/using-css-transitions-auto-dimensions/

function collapseSection(element) {
  // only proceed if height is null aka expansion has finished
  if (element.style.height != ""){
    return;
  }
  let sectionHeight = element.scrollHeight;
  let elementTransition = element.style.transition;
  let accordionItem = element.closest('.accordion');
  let seeDetailsBtn = accordionItem.querySelector('.accordion-toggle');
  
  element.style.transition = '';
  
  requestAnimationFrame(() => {
    element.style.height = sectionHeight + 'px';
    element.style.transition = elementTransition;
    requestAnimationFrame(() => {
      element.style.height = 0 + 'px';
    });
  });
  
  element.setAttribute('aria-expanded', 'false');
  accordionItem.classList.add('accordion--hidden');
  seeDetailsBtn.innerText = "Show";

}

function expandSection(element) {
  let sectionHeight = element.scrollHeight;
  let accordionItem = element.closest('.accordion');
  let seeDetailsBtn = accordionItem.querySelector('.accordion-toggle');
  element.style.height = sectionHeight + 'px';

  element.addEventListener('transitionend', (e) => {
    element.style.height = null;
  }, { once: true });
  
  element.setAttribute('aria-expanded', 'true');
  accordionItem.classList.remove('accordion--hidden');
  seeDetailsBtn.innerText = "Hide";
}