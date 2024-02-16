jQuery(document).ready(function($) {
  var showButton = $('.wp-block-ept-user-flow-my-business .claim-business-button');
  var claimBusinessContainer = document.querySelector('.wp-block-ept-user-flow-claim-business');

  const placesData = JSON.parse(claimBusinessContainer.dataset.places);

  if(showButton.length > 0) {
    claimBusinessContainer.style.display=('none');
    const blockTitle = claimBusinessContainer.querySelector('#block-title');
    showButton.click(function(event) {
      event.preventDefault();
      $(this).css('display', 'none');
      claimBusinessContainer.style.display=('flex');
      blockTitle.style.display=('none');
    });
  }
  
  const businessSearchInput = document.querySelector('.business-search');

  var lastSelectedLabel = "";

  $(businessSearchInput).autocomplete({
    source: placesData.map(place => ({ label: place.name, value: place.id })),
    appendTo:".wp-block-ept-user-flow-claim-business",
    select: function(event, ui) {
      event.preventDefault();
      $(this).val(ui.item.label);
      document.querySelector('#business-data').setAttribute('data-place-id', ui.item.value);
      lastSelectedLabel = ui.item.label;
    },
    open: function() {
      const inputWidth = $(businessSearchInput).outerWidth(); 

      $('.ui-autocomplete').css('width', inputWidth + 'px'); 
    }
  });

  $(businessSearchInput).on('input', function() {
    if ($(this).val().trim() !== lastSelectedLabel) {
      $('#business-data').attr('data-place-id', '');
    }
  });

  $(window).resize(function() {
    const businessSearchInput = document.querySelector('.business-search');

    const inputWidth = $(businessSearchInput).outerWidth();
    $('.ui-autocomplete').css('width', inputWidth + 'px'); 

    const inputOffset = $(businessSearchInput).offset();
    const inputHeight = $(businessSearchInput).outerHeight();

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
    var isConfirmed = false;
    fetch(`/wp-json/wp/v2/place/${selectedPlace.id}`)
      .then(response => response.json())
      .then(post => {
        if (!displayPostDetailsInPopup(post)){
          return; 
        }
      })
      try {
        const response = await fetch(ept_claim_business.claim, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(formData)
        });
  
        const responseData = await response.json();
  
        if (response.ok && responseData.status === 2) {
        } else {
          throw new Error(responseData.message || 'Failed to claim the business.');
        }
      } catch (error) {
        console.error('Error:', error);
      }
  });
});

function displayPostDetailsInPopup(post) {
  const modal = document.getElementById('submit-modal');
  const title = document.getElementById('modal-title');
  const link = document.getElementById('modal-link');
  const closeButton = document.querySelector('.close-button');
  const confirmButton = document.getElementById('confirm-button');

  title.textContent = `Title: ${post.title.rendered}`;
  link.href = post.link;

  modal.style.display = 'flex';

  confirmButton.onclick = function() {
    modal.style.display = 'none';
    return true;
};
  closeButton.onclick = function() {
      modal.style.display = 'none';
      return false;
  };

  window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
        return false;
      }
  };
}



