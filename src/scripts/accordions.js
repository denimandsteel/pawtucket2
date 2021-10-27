window.addEventListener('DOMContentLoaded', (event) => {
  
  let accordions = Array.from(document.querySelectorAll('.accordion'));
  let hierarchyBrowser = document.querySelector('#hierarchy');

  if(!accordions.length){
    return;
  }

  if(hierarchyBrowser){
    // Select the node that will be observed for mutations
    const targetNode = document.getElementById('hierarchy');
  
    // Options for the observer (which mutations to observe)
    const config = { childList: true, subtree: true };
  
    // Callback function to execute when mutations are observed
    const callback = function(mutationsList, observer) {
        for(const mutation of mutationsList) {
            if (mutation.type === 'childList') {
                // update so this only queries the buttons added in the mutation?
                let expandBtns = document.querySelectorAll('.accordion-toggle');
                addButtonListeners(expandBtns,accordionClickHandler);
                let moreBtns = document.querySelectorAll('.button.see-more');
                addButtonListeners(moreBtns, seeMoreClickHandler);
            }
        }
    };
  
    // Create an observer instance linked to the callback function
    const observer = new MutationObserver(callback);
  
    // Start observing the target node for configured mutations
    observer.observe(targetNode, config);
  
    // Later, you can stop observing
    // observer.disconnect();




  }

  // add event listeners to expand buttons
  let expandBtns = document.querySelectorAll('.accordion-toggle');

  addButtonListeners(expandBtns, accordionClickHandler);
});

function addButtonListeners(expandBtns, handler){

  expandBtns.forEach( btn => {
    btn.removeEventListener('click', handler);
    btn.addEventListener('click', handler);
  })
}

function accordionClickHandler(event){
  event.preventDefault();
  let seeDetailsBtn = event.target;
  let accordionItem = event.target.closest('.accordion');
  let detailsSection = accordionItem.querySelector('.accordion-details');
  let isCollapsed = ( detailsSection.getAttribute('aria-expanded') === "false" );
  let toggleText = seeDetailsBtn.dataset.toggleText;

  if(isCollapsed){
    expandSection(detailsSection);
    seeDetailsBtn.innerText = toggleText || "Hide";

  }
  else {
    collapseSection(detailsSection);
    seeDetailsBtn.innerText = toggleText || "Show";

  }
}

function seeMoreClickHandler(event) {
  event.preventDefault();
  let seeMoreBtn = event.target.parentNode;
  let parentList = event.target.closest('.collection');
  let childrenArray = Array.from(parentList.children);
  childrenArray.forEach(child => {
    child.classList.remove('collection-item--hidden');
  })
  seeMoreBtn.remove();
}

// modified from https://css-tricks.com/using-css-transitions-auto-dimensions/

function collapseSection(element) {
  // only proceed if height is null aka expansion has finished
  if (element.style.height != ""){
    return;
  }
  let sectionHeight = element.scrollHeight;
  let elementTransition = element.style.transition;
  let accordionItem = element.closest('.accordion');
  
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
}

function expandSection(element) {
  let sectionHeight = element.scrollHeight;
  let accordionItem = element.closest('.accordion');

  element.style.height = sectionHeight + 'px';

  element.addEventListener('transitionend', (e) => {
    element.style.height = null;
  }, { once: true });
  
  element.setAttribute('aria-expanded', 'true');
  accordionItem.classList.remove('accordion--hidden');

}