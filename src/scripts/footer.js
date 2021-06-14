window.onload = () => {
  fetch('/wp-json/belkin/v1/footer')
  .then(res => res.json())
  .then(res => document.querySelector('footer').innerHTML = JSON.parse(res))
}