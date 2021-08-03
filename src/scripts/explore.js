window.addEventListener('DOMContentLoaded', (event) => {

  const exploreSection = document.getElementById('explore');
  if(!exploreSection) {
    return;
  }
  const resultObjects = Array.from(exploreSection.querySelectorAll('.result-objects'));
  const filters = Array.from(exploreSection.querySelectorAll('.filters'));
  const curatorBios = Array.from(exploreSection.querySelectorAll('.frontpage-explore-bio'));
  const curatorBioMoreBtns = Array.from(exploreSection.querySelectorAll('#extend-bio'));
  const curatorGroups = Array.from(exploreSection.querySelectorAll('.frontpage-explore-group'));
  const curatorSelect = exploreSection.querySelector('#exploreCurator');
  
  // generate random curator index and random tag index
  const randCurator =  Math.floor(Math.random() * (curatorGroups.length));
  const randCuratorGroup = curatorGroups[randCurator];
  const randCuratorFilters = Array.from(randCuratorGroup.querySelectorAll('.filter-item'));
  const numberTags = randCuratorFilters.length;
  const randTag =  Math.floor(Math.random() * (numberTags)); 

  // hide all elements except the one you want shown
  const hideElements = function(objArray, exception = null) {
    objArray.forEach( (object, index) => {
      if (index === exception) return;
      object.classList.add('hidden');
    });
  }  

  const showTagGroup = function(curatorGroup, tagIndex) {
    const activeCuratorFilters = Array.from(curatorGroup.querySelectorAll('.filter-item'));
    const activeCuratorObjects = Array.from(curatorGroup.querySelectorAll('.result-objects'));
    activeCuratorFilters[tagIndex].classList.add('active');
    activeCuratorObjects[tagIndex].classList.remove('hidden');
  }  

  // set select index to the random curator
  curatorSelect.selectedIndex = randCurator;

  // hide all gruops/bios except for the randomly selected curator
  hideElements(curatorGroups, randCurator);
  hideElements(curatorBios, randCurator);

  // hide all objects
  hideElements(resultObjects);

  // show a random tag's objects from the random curator
  showTagGroup(randCuratorGroup, randTag);

  // Add toggle listeners to Select
  curatorSelect.addEventListener('change', (event) => {
    hideElements(curatorGroups);
    hideElements(curatorBios);
    hideElements(resultObjects);

    curatorGroups[event.target.value].classList.remove('hidden');
    curatorBios[event.target.value].classList.remove('hidden');

    //set first tag to active, show first result group
    const activeCuratorGroup =  curatorGroups[event.target.value];

    // set first tag to active and show objects from that tag
    showTagGroup(activeCuratorGroup, 0);
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

  //listeners for [more] toggles on bios
  curatorBioMoreBtns.forEach( (button) => {

    button.addEventListener('click', (event) => {
      event.preventDefault();
      let toggleButton = event.target;
      let buttonText = toggleButton.innerText;
      let extendedBio = toggleButton.nextElementSibling;
  
      //change text to [less]
      toggleButton.innerText = (buttonText == "[more]") ? "[less]" : "[more]";
      //show extendedBio
      extendedBio.classList.toggle('hidden');
    })
  })
});
