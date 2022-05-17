window.addEventListener('DOMContentLoaded', (event) => {
  
  let hiddenItems = document.querySelectorAll('.hidden-from-notice');

  if(hiddenItems.length < 1){
    return;
  }

  const noticeMessage = document.querySelector('.web-notice');
  const continueButton = noticeMessage.querySelector('#webNoticeContinue');
  const backButton = noticeMessage.querySelector('#webNoticeBack');
  const hideButton = document.querySelector('#webNoticeHide');

  continueButton.addEventListener('click', (event) => {
    hiddenItems.forEach( item => {
      item.classList.toggle('hidden-from-notice');
    })

    //hide
    noticeMessage.style.display = "none"; 
  })

  hideButton.addEventListener('click', (event) => {
    hiddenItems.forEach( item => {
      item.classList.toggle('hidden-from-notice');
    })

    //show
    noticeMessage.style.display = "flex"; 
  })

  backButton.addEventListener('click', (event) => {
    history.back();
  })
});