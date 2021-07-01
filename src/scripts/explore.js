window.addEventListener('DOMContentLoaded', (event) => {

  const exploreSection = document.getElementById('explore');
  if(!exploreSection) {
    return;
  }
  const resultObjects = Array.from(exploreSection.querySelectorAll('.result-objects'));
  const filters = Array.from(exploreSection.querySelectorAll('.filters'));
  const curatorBios = Array.from(exploreSection.querySelectorAll('.frontpage-explore-bio'));
  const curatorSelect = exploreSection.querySelector('#exploreCurator');
  
  const hideNotFirst = function(objArray) {
    objArray.forEach( (object, index) => {
      if (index === 0) return;
      object.classList.add('hidden');
    });
  }

  const hideAll = function(objArray) {
    objArray.forEach( (object, index) => {
      object.classList.add('hidden');
    });
  }

  
  // hide all results objects and filters exccept first
  hideNotFirst(resultObjects);
  hideNotFirst(filters);
  hideNotFirst(curatorBios);

  // Add toggle listeners to Select, filters and [more] buttons
  curatorSelect.addEventListener('change', (event) => {
    //hide all
    hideAll(resultObjects);
    hideAll(filters);
    hideAll(curatorBios);
    // show selected curator's bio, filter list, and first object result
    let resultObjectsToShow =  filters[event.target.value].nextElementSibling.firstElementChild;
    resultObjectsToShow.classList.remove('hidden');
    filters[event.target.value].classList.remove('hidden');
    curatorBios[event.target.value].classList.remove('hidden');
  })
  
  // Add listeners to filter buttons to switch result objects
  filters.forEach( (filterGroup) => {
    let filterItems = Array.from(filterGroup.querySelectorAll('.filter-item'));
    let resultObjectContainer =  filterGroup.nextElementSibling;
    let resultObjects = Array.from(resultObjectContainer.querySelectorAll('.result-objects'));
    filterItems.forEach( (filter) => {
      filter.addEventListener('click', (event) => {
        let activeItem = filterGroup.querySelector('.filter-item.active');
        let index = filterItems.indexOf(event.target);
        let activeObjects = resultObjectContainer.querySelector('div.result-objects:not(.hidden)');
        // update list active state
        activeItem.classList.remove('active');
        event.target.classList.add('active');
        // update object hidden state
        activeObjects.classList.add('hidden');
        resultObjects[index].classList.remove('hidden');
      })
    })
  })

});
