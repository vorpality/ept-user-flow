jQuery(document).ready(function($) {
  var showButton = $('.wp-block-ept-user-flow-my-business .add-event-button');
  var addEventContainer = document.querySelector('.wp-block-ept-pe-update-event');

  if(showButton.length > 0) {
    addEventContainer.style.display=('none');
    showButton.click(function(event) {
      event.preventDefault();
      $(this).css('display', 'none');
      addEventContainer.style.display=('flex');
    });
  }

});