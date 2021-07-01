window.onload = () => {
  fetch('https://belkin.ubc.ca/wp-json/belkin/v1/footer')
  .then(res => res.json())
  .then(res => document.querySelector('footer').innerHTML = JSON.parse(res))
}