jQuery(document).ready(function($) {
  const claimBusinessContainer = document.querySelector('.wp-block-ept-user-flow-claim-business');

  const placesData = JSON.parse(claimBusinessContainer.dataset.places);
  const businessSearchInput = document.querySelector('.business-search');

  $(businessSearchInput).autocomplete({
    source: placesData.map(place => ({ label: place.name, value: place.id })),
    select: function(event, ui) {
      document.querySelector('#business-data').setAttribute('data-place-id', ui.item.value);
    },
    open: function() {
      const inputWidth = $(businessSearchInput).outerWidth(); // Get the outer width of the input field
      $('.ui-autocomplete').css('width', inputWidth + 'px'); // Set the width of the dropdown menu
    }
  });

  $(window).resize(function() {
    const businessSearchInput = document.querySelector('.business-search');

    const inputWidth = $(businessSearchInput).outerWidth(); // Get the outer width of the input field
    $('.ui-autocomplete').css('width', inputWidth + 'px'); // Set the width of the dropdown menu

    // Get the position of the input field
    const inputOffset = $(businessSearchInput).offset();
    const inputHeight = $(businessSearchInput).outerHeight();

    // Position the dropdown right below the input field
    $('.ui-autocomplete').css({
      top: inputOffset.top + inputHeight,
      left: inputOffset.left
    });
  });
});



document.addEventListener('DOMContentLoaded', () => {
  const claimBusinessContainer = document.querySelector('.wp-block-ept-user-flow-claim-business');
  const claimForm = document.querySelector('#own-business-form');
  const placesData = JSON.parse(claimBusinessContainer.dataset.places);

  claimForm?.addEventListener('submit', async event => {
    event.preventDefault();

    const business_data = document.querySelector('#business-data');
    const business_id = business_data.getAttribute('data-place-id');
    const user_id = business_data.getAttribute('data-user-id');

    const formData = {
      user_id:user_id,
      business_id:business_id
    }
    const selectedPlace = placesData.find(place => place.id == business_id);
    const isConfirmed = confirm(`Are you sure you want to claim ${selectedPlace.name}?`);
    
    if (!isConfirmed) {
      return; 
    }
    try {
      const response = await fetch('http://localhost/wp-json/ept/v1/claim-business', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      });

      const responseData = await response.json();

      if (response.ok && responseData.status === 2) {
        console.log('ok');
      } else {
        throw new Error(responseData.message || 'Failed to claim the business.');
      }
    } catch (error) {
      console.error('Error:', error);
    }
  });
});


