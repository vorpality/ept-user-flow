import { mapAutoComplete } from "../../common/services/mapAutoComplete.js";
import { mapSelect } from "../../common/services/selectFromMap.js";

document.addEventListener('DOMContentLoaded', () => {
  if (!document.querySelector('.wp-block-ept-user-flow-locationeer')){
    return;
  }
  const field = document.getElementById('user-address');
  const lat = document.getElementById('location-lat');
  const lng = document.getElementById('location-lng');
  const checkSetterName = "check";
  const openButton = document.getElementById('map-select');
  openButton.addEventListener('click', (event) => { event.preventDefault()});

  mapAutoComplete({
    main:field,
    lat:lat,
    lng:lng,
    setterName : checkSetterName
  })

  mapSelect ({
    mainFields : {
      lat : lat,
      lng : lng,
      input : field
    },
    tempFields : {
      lat : document.getElementById('temp-lat'),
      lng : document.getElementById('temp-lng')
    },
    modal : {
      content : document.getElementById('map-popup'),
      confirmButton : document.getElementById('confirm-location'),
      openButton :openButton,
      closeButton : Array.from(document.querySelectorAll('.close-popup'))
    },
    startingPosition : {lat:37.98, lng:23.725}
  })





const banner = document.querySelector('.wp-block-ept-user-flow-locationeer');
const invalidPopup = document.getElementById('invalid-address-popup');
  
  const acceptButton = document.querySelector('#submit-location');
  acceptButton.addEventListener('click',event =>{
    event.preventDefault();
    if (field.getAttribute('valid') == 1){
      const expires = new Date();
      expires.setMonth(expires.getMonth() + 12);
      document.cookie = 'location=set;expires='+expires+';path=/'
      document.cookie = 'location.lat='+lat.value+';expires='+expires+';path=/'
      document.cookie = 'location.lng='+lng.value+';expires='+expires+';path=/'
      banner.style.display = 'none';
    }
    else {
      invalidPopup.style.display = 'block';
      acceptButton.addEventListener('mouseout', function() {
        invalidPopup.style.display = 'none';
      });
    }
  })

  const rejectButton = document.querySelector('#skip-location');
  rejectButton.addEventListener('click',event =>{
    event.preventDefault();
    
    const expires = new Date();
    expires.setMonth(expires.getHours() + 1);
    document.cookie = 'location=skip;expires='+expires+';path=/'
    banner.classList.add('hidden');
})


})