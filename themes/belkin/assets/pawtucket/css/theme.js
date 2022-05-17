// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles
parcelRequire = (function (modules, cache, entry, globalName) {
  // Save the require from previous bundle to this closure if any
  var previousRequire = typeof parcelRequire === 'function' && parcelRequire;
  var nodeRequire = typeof require === 'function' && require;

  function newRequire(name, jumped) {
    if (!cache[name]) {
      if (!modules[name]) {
        // if we cannot find the module within our internal map or
        // cache jump to the current global require ie. the last bundle
        // that was added to the page.
        var currentRequire = typeof parcelRequire === 'function' && parcelRequire;
        if (!jumped && currentRequire) {
          return currentRequire(name, true);
        }

        // If there are other bundles on this page the require from the
        // previous one is saved to 'previousRequire'. Repeat this as
        // many times as there are bundles until the module is found or
        // we exhaust the require chain.
        if (previousRequire) {
          return previousRequire(name, true);
        }

        // Try the node require function if it exists.
        if (nodeRequire && typeof name === 'string') {
          return nodeRequire(name);
        }

        var err = new Error('Cannot find module \'' + name + '\'');
        err.code = 'MODULE_NOT_FOUND';
        throw err;
      }

      localRequire.resolve = resolve;
      localRequire.cache = {};

      var module = cache[name] = new newRequire.Module(name);

      modules[name][0].call(module.exports, localRequire, module, module.exports, this);
    }

    return cache[name].exports;

    function localRequire(x){
      return newRequire(localRequire.resolve(x));
    }

    function resolve(x){
      return modules[name][1][x] || x;
    }
  }

  function Module(moduleName) {
    this.id = moduleName;
    this.bundle = newRequire;
    this.exports = {};
  }

  newRequire.isParcelRequire = true;
  newRequire.Module = Module;
  newRequire.modules = modules;
  newRequire.cache = cache;
  newRequire.parent = previousRequire;
  newRequire.register = function (id, exports) {
    modules[id] = [function (require, module) {
      module.exports = exports;
    }, {}];
  };

  var error;
  for (var i = 0; i < entry.length; i++) {
    try {
      newRequire(entry[i]);
    } catch (e) {
      // Save first error but execute all entries
      if (!error) {
        error = e;
      }
    }
  }

  if (entry.length) {
    // Expose entry point to Node, AMD or browser globals
    // Based on https://github.com/ForbesLindesay/umd/blob/master/template.js
    var mainExports = newRequire(entry[entry.length - 1]);

    // CommonJS
    if (typeof exports === "object" && typeof module !== "undefined") {
      module.exports = mainExports;

    // RequireJS
    } else if (typeof define === "function" && define.amd) {
     define(function () {
       return mainExports;
     });

    // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }

  // Override the current require with this new one
  parcelRequire = newRequire;

  if (error) {
    // throw error from earlier, _after updating parcelRequire_
    throw error;
  }

  return newRequire;
})({"../node_modules/parcel-bundler/src/builtins/bundle-url.js":[function(require,module,exports) {
var bundleURL = null;

function getBundleURLCached() {
  if (!bundleURL) {
    bundleURL = getBundleURL();
  }

  return bundleURL;
}

function getBundleURL() {
  // Attempt to find the URL of the current script and use that as the base URL
  try {
    throw new Error();
  } catch (err) {
    var matches = ('' + err.stack).match(/(https?|file|ftp|chrome-extension|moz-extension):\/\/[^)\n]+/g);

    if (matches) {
      return getBaseURL(matches[0]);
    }
  }

  return '/';
}

function getBaseURL(url) {
  return ('' + url).replace(/^((?:https?|file|ftp|chrome-extension|moz-extension):\/\/.+)?\/[^/]+(?:\?.*)?$/, '$1') + '/';
}

exports.getBundleURL = getBundleURLCached;
exports.getBaseURL = getBaseURL;
},{}],"../node_modules/parcel-bundler/src/builtins/css-loader.js":[function(require,module,exports) {
var bundle = require('./bundle-url');

function updateLink(link) {
  var newLink = link.cloneNode();

  newLink.onload = function () {
    link.remove();
  };

  newLink.href = link.href.split('?')[0] + '?' + Date.now();
  link.parentNode.insertBefore(newLink, link.nextSibling);
}

var cssTimeout = null;

function reloadCSS() {
  if (cssTimeout) {
    return;
  }

  cssTimeout = setTimeout(function () {
    var links = document.querySelectorAll('link[rel="stylesheet"]');

    for (var i = 0; i < links.length; i++) {
      if (bundle.getBaseURL(links[i].href) === bundle.getBundleURL()) {
        updateLink(links[i]);
      }
    }

    cssTimeout = null;
  }, 50);
}

module.exports = reloadCSS;
},{"./bundle-url":"../node_modules/parcel-bundler/src/builtins/bundle-url.js"}],"styles/theme.scss":[function(require,module,exports) {
var reloadCSS = require('_css_loader');

module.hot.dispose(reloadCSS);
module.hot.accept(reloadCSS);
},{"_css_loader":"../node_modules/parcel-bundler/src/builtins/css-loader.js"}],"scripts/explore.js":[function(require,module,exports) {
window.addEventListener('DOMContentLoaded', event => {
  const exploreSection = document.getElementById('explore');

  if (!exploreSection) {
    return;
  }

  const resultObjects = Array.from(exploreSection.querySelectorAll('.result-objects'));
  const filters = Array.from(exploreSection.querySelectorAll('.filters'));
  const curatorBios = Array.from(exploreSection.querySelectorAll('.frontpage-explore-bio'));
  const curatorBioMoreBtns = Array.from(exploreSection.querySelectorAll('#extend-bio'));
  const curatorGroups = Array.from(exploreSection.querySelectorAll('.frontpage-explore-group'));
  const curatorSelect = exploreSection.querySelector('#exploreCurator'); // generate random curator index and random tag index

  const randCurator = Math.floor(Math.random() * curatorGroups.length);
  const randCuratorGroup = curatorGroups[randCurator];
  const randCuratorFilters = Array.from(randCuratorGroup.querySelectorAll('.filter-item'));
  const numberTags = randCuratorFilters.length;
  const randTag = Math.floor(Math.random() * numberTags); // hide all elements except the one you want shown

  const hideElements = function (objArray, exception = null) {
    objArray.forEach((object, index) => {
      if (index === exception) return;
      object.classList.add('hidden');
    });
  };

  const showTagGroup = function (curatorGroup, tagIndex) {
    const activeCuratorFilters = Array.from(curatorGroup.querySelectorAll('.filter-item'));
    const activeCuratorObjects = Array.from(curatorGroup.querySelectorAll('.result-objects'));
    activeCuratorFilters.forEach(filter => filter.classList.remove('active'));
    activeCuratorFilters[tagIndex].classList.add('active');
    activeCuratorObjects[tagIndex].classList.remove('hidden');
  }; // set select index to the random curator


  curatorSelect.selectedIndex = randCurator; // hide all gruops/bios except for the randomly selected curator

  hideElements(curatorGroups, randCurator);
  hideElements(curatorBios, randCurator); // hide all objects

  hideElements(resultObjects); // show a random tag's objects from the random curator

  showTagGroup(randCuratorGroup, randTag); // Add toggle listeners to Select

  curatorSelect.addEventListener('change', event => {
    hideElements(curatorGroups);
    hideElements(curatorBios);
    hideElements(resultObjects);
    curatorGroups[event.target.value].classList.remove('hidden');
    curatorBios[event.target.value].classList.remove('hidden'); //set first tag to active, show first result group

    const activeCuratorGroup = curatorGroups[event.target.value]; // set first tag to active and show objects from that tag

    showTagGroup(activeCuratorGroup, 0);
  }); // Add listeners to filter buttons to switch result objects

  filters.forEach(filterGroup => {
    let filterItems = Array.from(filterGroup.querySelectorAll('.filter-item'));
    let resultObjectContainer = filterGroup.nextElementSibling;
    let resultObjects = Array.from(resultObjectContainer.querySelectorAll('.result-objects'));
    filterItems.forEach(filter => {
      filter.addEventListener('click', event => {
        let activeItem = filterGroup.querySelector('.filter-item.active');
        let index = filterItems.indexOf(event.target);
        let activeObjects = resultObjectContainer.querySelector('div.result-objects:not(.hidden)'); // update list active state

        activeItem.classList.remove('active');
        event.target.classList.add('active'); // update object hidden state

        activeObjects.classList.add('hidden');
        resultObjects[index].classList.remove('hidden');
      });
    });
  }); //listeners for [more] toggles on bios

  curatorBioMoreBtns.forEach(button => {
    button.addEventListener('click', event => {
      event.preventDefault();
      let toggleButton = event.target;
      let buttonText = toggleButton.innerText;
      let extendedBio = toggleButton.nextElementSibling; //change text to [less]

      toggleButton.innerText = buttonText == "[more]" ? "[less]" : "[more]"; //show extendedBio

      extendedBio.classList.toggle('hidden');
    });
  });
});
},{}],"scripts/accordions.js":[function(require,module,exports) {
window.addEventListener('DOMContentLoaded', event => {
  let accordions = Array.from(document.querySelectorAll('.accordion'));
  let hierarchyBrowser = document.querySelector('#hierarchy');

  if (!accordions.length) {
    return;
  }

  if (hierarchyBrowser) {
    // Select the node that will be observed for mutations
    const targetNode = document.getElementById('hierarchy'); // Options for the observer (which mutations to observe)

    const config = {
      childList: true,
      subtree: true
    }; // Callback function to execute when mutations are observed

    const callback = function (mutationsList, observer) {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList') {
          // update so this only queries the buttons added in the mutation?
          let expandBtns = document.querySelectorAll('.accordion-toggle');
          addButtonListeners(expandBtns, accordionClickHandler);
          let moreBtns = document.querySelectorAll('.button.see-more');
          addButtonListeners(moreBtns, seeMoreClickHandler);
        }
      }
    }; // Create an observer instance linked to the callback function


    const observer = new MutationObserver(callback); // Start observing the target node for configured mutations

    observer.observe(targetNode, config); // Later, you can stop observing
    // observer.disconnect();
  } // add event listeners to expand buttons


  let expandBtns = document.querySelectorAll('.accordion-toggle');
  addButtonListeners(expandBtns, accordionClickHandler);
});

function addButtonListeners(expandBtns, handler) {
  expandBtns.forEach(btn => {
    btn.removeEventListener('click', handler);
    btn.addEventListener('click', handler);
  });
}

function accordionClickHandler(event) {
  event.preventDefault();
  let seeDetailsBtn = event.target;
  let accordionItem = event.target.closest('.accordion');
  let detailsSection = accordionItem.querySelector('.accordion-details');
  let isCollapsed = detailsSection.getAttribute('aria-expanded') === "false";
  let toggleText = seeDetailsBtn.dataset.toggleText;

  if (isCollapsed) {
    expandSection(detailsSection);
    seeDetailsBtn.innerText = toggleText || "Hide";
  } else {
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
  });
  seeMoreBtn.remove();
} // modified from https://css-tricks.com/using-css-transitions-auto-dimensions/


function collapseSection(element) {
  // only proceed if height is null aka expansion has finished
  if (element.style.height != "") {
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
  element.addEventListener('transitionend', e => {
    element.style.height = null;
  }, {
    once: true
  });
  element.setAttribute('aria-expanded', 'true');
  accordionItem.classList.remove('accordion--hidden');
}
},{}],"scripts/filters.js":[function(require,module,exports) {
window.addEventListener('DOMContentLoaded', event => {
  // Get relevant elements and collections
  const filter = document.querySelector('#filterGroups');

  if (!filter) {
    return;
  }

  ;
  const tablist = filter.querySelector('.filter-header');
  const moreResults = filter.querySelector('.filter-more-results');
  const tabs = Array.from(tablist.querySelectorAll('.filter-tab'));
  const panels = filter.querySelectorAll('.filter-group');
  moreResults.style.display = 'none';

  const switchTab = (oldTab, newTab) => {
    newTab.focus(); // Make the active tab focusable by the user (Tab key)

    newTab.removeAttribute('tabindex'); // Set the selected state

    newTab.setAttribute('aria-selected', 'true');
    oldTab.removeAttribute('aria-selected');
    oldTab.setAttribute('tabindex', '-1'); //to deal with jQuery for more results element

    moreResults.style.display = 'none';
    panels.forEach(panel => {
      panel.style.display = 'block';
    }); // Get the indices of the new and old tabs to find the correct
    // tab panels to show and hide

    let index = tabs.indexOf(newTab);
    let oldIndex = tabs.indexOf(oldTab);
    panels[oldIndex].hidden = true;
    panels[index].hidden = false;
  };

  tabs.forEach((tab, i) => {
    // Handle clicking of tabs for mouse users
    tab.addEventListener('click', e => {
      e.preventDefault();
      let currentTab = tablist.querySelector('[aria-selected]');

      if (e.currentTarget !== currentTab) {
        switchTab(currentTab, e.currentTarget);
      }
    }); // Handle keydown events for keyboard users

    tab.addEventListener('keydown', e => {
      // Get the index of the current tab in the tabs node list
      let index = tabs.indexOf(e.currentTarget); // Work out which key the user is pressing and
      // Calculate the new tab's index where appropriate

      let dir = e.which === 37 ? index - 1 : e.which === 39 ? index + 1 : e.which === 40 ? 'down' : null;

      if (dir !== null) {
        e.preventDefault(); // If the down key is pressed, move focus to the open panel,
        // otherwise switch to the adjacent tab

        dir === 'down' ? panels[i].focus() : tabs[dir] ? switchTab(e.currentTarget, tabs[dir]) : void 0;
      }
    });
  }); // Add tab panel semantics and hide them all

  panels.forEach((panel, i) => {
    panel.hidden = true;
  }); // Initially activate the first tab and reveal the first tab panel

  tabs[0].removeAttribute('tabindex');
  tabs[0].setAttribute('aria-selected', 'true');
  panels[0].hidden = false;
}); // });
},{}],"scripts/dropdowns.js":[function(require,module,exports) {
window.addEventListener('DOMContentLoaded', event => {
  const dropdowns = Array.from(document.querySelectorAll('.dropdown'));

  if (!dropdowns) {
    return;
  }

  dropdowns.forEach(dropdown => {
    const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
    const dropdownList = dropdown.querySelector('.dropdown-list'); //add event listener to button

    dropdownToggle.addEventListener('click', event => {
      dropdownList.classList.toggle('hidden');
      event.preventDefault();
    });
  });
});
},{}],"scripts/content-warning.js":[function(require,module,exports) {
window.addEventListener('DOMContentLoaded', event => {
  let hiddenItems = document.querySelectorAll('.hidden-from-notice');

  if (hiddenItems.length < 1) {
    return;
  }

  const noticeMessage = document.querySelector('.web-notice');
  const continueButton = noticeMessage.querySelector('#webNoticeContinue');
  const backButton = noticeMessage.querySelector('#webNoticeBack');
  const hideButton = document.querySelector('#webNoticeHide');
  continueButton.addEventListener('click', event => {
    hiddenItems.forEach(item => {
      item.classList.toggle('hidden-from-notice');
    }); //hide

    noticeMessage.style.display = "none";
  });
  hideButton.addEventListener('click', event => {
    hiddenItems.forEach(item => {
      item.classList.toggle('hidden-from-notice');
    }); //show

    noticeMessage.style.display = "flex";
  });
  backButton.addEventListener('click', event => {
    history.back();
  });
});
},{}],"scripts/search-type.js":[function(require,module,exports) {
// Toggle Search type on Advanced Search form
window.addEventListener('DOMContentLoaded', event => {
  let buttons = document.querySelectorAll('.button--search-type');

  if (buttons.length < 1) {
    return;
  }

  let searchForm = document.querySelector('.search-form');
  let textInput = searchForm.querySelector('#_fulltext');
  let advancedInput = searchForm.querySelector('#advancedSearchInput');
  let pageWrapper = document.getElementById("pageArea");

  if (pageWrapper.classList.contains('ca_collections')) {
    // if collections search
    searchForm.setAttribute('action', "/index.php/Search/collections/search/");
    textInput.placeholder = "Search Collections by Keyword";
    advancedInput.value = 0;
    toggleAriaPressed(buttons[0]);
    toggleAriaPressed(buttons[1]);
    searchForm.classList.toggle('collection-search');
  }

  buttons.forEach(btn => {
    btn.addEventListener('click', event => {
      let clickedButton = event.target;
      let otherButton = clickedButton.nextElementSibling.classList.contains('button--search-type') ? clickedButton.nextElementSibling : clickedButton.previousElementSibling; // if already active, return

      if (clickedButton.getAttribute('aria-pressed') === 'true') {
        return;
      }

      toggleAriaPressed(clickedButton);
      toggleAriaPressed(otherButton);
      searchForm.classList.toggle('collection-search');

      if (clickedButton.id == 'collectionSearchButton') {
        searchForm.setAttribute('action', "/index.php/Search/collections/search/");
        textInput.placeholder = "Search Collections by Keyword";
        advancedInput.value = 0; // let submitButton = 
      } else {
        searchForm.setAttribute('action', "/index.php/Search/objects");
        textInput.placeholder = "Search Objects by Keyword";
        advancedInput.value = 1;
      }
    });
  });

  function toggleAriaPressed(element) {
    let ariaPressed = element.getAttribute('aria-pressed') === 'true';
    element.setAttribute('aria-pressed', !ariaPressed);
  }
});
},{}],"scripts/footer.js":[function(require,module,exports) {
window.onload = () => {
  fetch('https://belkin.ubc.ca/wp-json/belkin/v1/footer').then(res => res.json()).then(res => document.querySelector('footer').innerHTML = JSON.parse(res));
};
},{}],"theme.js":[function(require,module,exports) {
"use strict";

require("./styles/theme");

require("./scripts/explore");

require("./scripts/accordions");

require("./scripts/filters");

require("./scripts/dropdowns");

require("./scripts/content-warning");

require("./scripts/search-type");

require("./scripts/footer");
},{"./styles/theme":"styles/theme.scss","./scripts/explore":"scripts/explore.js","./scripts/accordions":"scripts/accordions.js","./scripts/filters":"scripts/filters.js","./scripts/dropdowns":"scripts/dropdowns.js","./scripts/content-warning":"scripts/content-warning.js","./scripts/search-type":"scripts/search-type.js","./scripts/footer":"scripts/footer.js"}],"../node_modules/parcel-bundler/src/builtins/hmr-runtime.js":[function(require,module,exports) {
var global = arguments[3];
var OVERLAY_ID = '__parcel__error__overlay__';
var OldModule = module.bundle.Module;

function Module(moduleName) {
  OldModule.call(this, moduleName);
  this.hot = {
    data: module.bundle.hotData,
    _acceptCallbacks: [],
    _disposeCallbacks: [],
    accept: function (fn) {
      this._acceptCallbacks.push(fn || function () {});
    },
    dispose: function (fn) {
      this._disposeCallbacks.push(fn);
    }
  };
  module.bundle.hotData = null;
}

module.bundle.Module = Module;
var checkedAssets, assetsToAccept;
var parent = module.bundle.parent;

if ((!parent || !parent.isParcelRequire) && typeof WebSocket !== 'undefined') {
  var hostname = "" || location.hostname;
  var protocol = location.protocol === 'https:' ? 'wss' : 'ws';
  var ws = new WebSocket(protocol + '://' + hostname + ':' + "49516" + '/');

  ws.onmessage = function (event) {
    checkedAssets = {};
    assetsToAccept = [];
    var data = JSON.parse(event.data);

    if (data.type === 'update') {
      var handled = false;
      data.assets.forEach(function (asset) {
        if (!asset.isNew) {
          var didAccept = hmrAcceptCheck(global.parcelRequire, asset.id);

          if (didAccept) {
            handled = true;
          }
        }
      }); // Enable HMR for CSS by default.

      handled = handled || data.assets.every(function (asset) {
        return asset.type === 'css' && asset.generated.js;
      });

      if (handled) {
        console.clear();
        data.assets.forEach(function (asset) {
          hmrApply(global.parcelRequire, asset);
        });
        assetsToAccept.forEach(function (v) {
          hmrAcceptRun(v[0], v[1]);
        });
      } else if (location.reload) {
        // `location` global exists in a web worker context but lacks `.reload()` function.
        location.reload();
      }
    }

    if (data.type === 'reload') {
      ws.close();

      ws.onclose = function () {
        location.reload();
      };
    }

    if (data.type === 'error-resolved') {
      console.log('[parcel] ✨ Error resolved');
      removeErrorOverlay();
    }

    if (data.type === 'error') {
      console.error('[parcel] 🚨  ' + data.error.message + '\n' + data.error.stack);
      removeErrorOverlay();
      var overlay = createErrorOverlay(data);
      document.body.appendChild(overlay);
    }
  };
}

function removeErrorOverlay() {
  var overlay = document.getElementById(OVERLAY_ID);

  if (overlay) {
    overlay.remove();
  }
}

function createErrorOverlay(data) {
  var overlay = document.createElement('div');
  overlay.id = OVERLAY_ID; // html encode message and stack trace

  var message = document.createElement('div');
  var stackTrace = document.createElement('pre');
  message.innerText = data.error.message;
  stackTrace.innerText = data.error.stack;
  overlay.innerHTML = '<div style="background: black; font-size: 16px; color: white; position: fixed; height: 100%; width: 100%; top: 0px; left: 0px; padding: 30px; opacity: 0.85; font-family: Menlo, Consolas, monospace; z-index: 9999;">' + '<span style="background: red; padding: 2px 4px; border-radius: 2px;">ERROR</span>' + '<span style="top: 2px; margin-left: 5px; position: relative;">🚨</span>' + '<div style="font-size: 18px; font-weight: bold; margin-top: 20px;">' + message.innerHTML + '</div>' + '<pre>' + stackTrace.innerHTML + '</pre>' + '</div>';
  return overlay;
}

function getParents(bundle, id) {
  var modules = bundle.modules;

  if (!modules) {
    return [];
  }

  var parents = [];
  var k, d, dep;

  for (k in modules) {
    for (d in modules[k][1]) {
      dep = modules[k][1][d];

      if (dep === id || Array.isArray(dep) && dep[dep.length - 1] === id) {
        parents.push(k);
      }
    }
  }

  if (bundle.parent) {
    parents = parents.concat(getParents(bundle.parent, id));
  }

  return parents;
}

function hmrApply(bundle, asset) {
  var modules = bundle.modules;

  if (!modules) {
    return;
  }

  if (modules[asset.id] || !bundle.parent) {
    var fn = new Function('require', 'module', 'exports', asset.generated.js);
    asset.isNew = !modules[asset.id];
    modules[asset.id] = [fn, asset.deps];
  } else if (bundle.parent) {
    hmrApply(bundle.parent, asset);
  }
}

function hmrAcceptCheck(bundle, id) {
  var modules = bundle.modules;

  if (!modules) {
    return;
  }

  if (!modules[id] && bundle.parent) {
    return hmrAcceptCheck(bundle.parent, id);
  }

  if (checkedAssets[id]) {
    return;
  }

  checkedAssets[id] = true;
  var cached = bundle.cache[id];
  assetsToAccept.push([bundle, id]);

  if (cached && cached.hot && cached.hot._acceptCallbacks.length) {
    return true;
  }

  return getParents(global.parcelRequire, id).some(function (id) {
    return hmrAcceptCheck(global.parcelRequire, id);
  });
}

function hmrAcceptRun(bundle, id) {
  var cached = bundle.cache[id];
  bundle.hotData = {};

  if (cached) {
    cached.hot.data = bundle.hotData;
  }

  if (cached && cached.hot && cached.hot._disposeCallbacks.length) {
    cached.hot._disposeCallbacks.forEach(function (cb) {
      cb(bundle.hotData);
    });
  }

  delete bundle.cache[id];
  bundle(id);
  cached = bundle.cache[id];

  if (cached && cached.hot && cached.hot._acceptCallbacks.length) {
    cached.hot._acceptCallbacks.forEach(function (cb) {
      cb();
    });

    return true;
  }
}
},{}]},{},["../node_modules/parcel-bundler/src/builtins/hmr-runtime.js","theme.js"], null)