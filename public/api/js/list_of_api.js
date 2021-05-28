$(document).ready(() => {
    function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          x.innerHTML = "Geolocation is not supported by this browser.";
        }
      }
});

const datas = 
[
    {datamall: {
        displaylink: ''
    }}
];