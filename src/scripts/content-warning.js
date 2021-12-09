window.addEventListener('DOMContentLoaded', (event) => {
  
  let hiddenItems = document.querySelectorAll('.hidden-from-notice');

  if(hiddenItems.length < 1){
    return;
  }

  const noticeMessage = document.querySelector('.web-notice');
  const continueButton = noticeMessage.querySelector('#webNoticeContinue');
  const backButton = noticeMessage.querySelector('#webNoticeBack');

  continueButton.addEventListener('click', (event) => {
    hiddenItems.forEach( item => {
      console.log(item);
      item.classList.toggle('hidden-from-notice');
    })

    //hide
    noticeMessage.style.display = "none"; 
  })

  backButton.addEventListener('click', (event) => {
    history.back();
  })
});