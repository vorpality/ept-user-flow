import {__} from '@wordpress/i18n'
import {render, useState, useEffect} from '@wordpress/element'
import { createRoot } from "react-dom/client";

const FileUploadComponent = () => {
  const [selectedFiles, setSelectedFiles] = useState([]);
  
  const handleFileChange = (event) => {
    setSelectedFiles([...event.target.files]);
  };

  useEffect(() => {
    window.currentSelectedFiles = selectedFiles; 
  }, [selectedFiles]); 

  const removeFile = (indexToRemove) => {
    setSelectedFiles(selectedFiles.filter((_, index) => index !== indexToRemove));
  };

  const truncateFileName = (name) => {
    return name.length > 20 ? `${name.slice(0, 20)}...` : name;
  };
  return(
    <>
      <label htmlFor="event-images" className="file-upload-button">Choose Files</label>
      <input 
        type="file" 
        id="event-images" 
        name="event_images[]" 
        multiple 
        onChange={handleFileChange} 
        style={{ display: 'none' }} 
      />
      <div className="file-list">
        {selectedFiles.map((file, index) => (
          <div key={index} className="file-entry">
            <span className="file-name">{truncateFileName(file.name)}</span>
            <span className="remove-file" onClick={() => removeFile(index)}>&#10005;</span>
          </div>
        ))}
      </div>
    </>
  );
}

jQuery(document).ready(function($) {
  var showButton = $('.wp-block-ept-user-flow-my-business .add-event-button');
  var addEventContainer = document.querySelector('.wp-block-ept-user-flow-add-event');

  if(showButton.length > 0) {
    addEventContainer.style.display=('none');
    showButton.click(function(event) {
      event.preventDefault();
      $(this).css('display', 'none');
      addEventContainer.style.display=('flex');
    });
  }

});

document.addEventListener('DOMContentLoaded', () => {
  const root_element = document.querySelector('.file-upload-wrapper');
  const root = createRoot(root_element);
  root.render(<FileUploadComponent />)

  const add_event_form = document.querySelector('#add-event-form');

  add_event_form?.addEventListener('submit', async event => {
    event.preventDefault();

    const add_event_form_fieldset = add_event_form.querySelector('fieldset')
    add_event_form_fieldset.setAttribute('disabled', true)

    const add_event_status = add_event_form.querySelector('#form-status')
    add_event_status.innerHTML = `
      <div class ="modal-status modal-status-info">
      ${__('Please wait! We are processing your request.', 'e-potis')}
      </div>
    `   

    const userID=add_event_form.querySelector('#user-id').value;
    const title=add_event_form.querySelector('#event-title').value;
    const description=add_event_form.querySelector('#event-description').value;
    const location=add_event_form.querySelector('#event-location').value;
    event.preventDefault();
    add_event_form_fieldset.removeAttribute('disabled');
     
    const formData = new FormData();
    formData.append('user_id', userID);
    formData.append('event_title', title);
    formData.append('event_description', description);
    formData.append('event_location', location);
    window.currentSelectedFiles.forEach((file, index) => {
      formData.append(`event_images[${index}]`, file);
    });

    const response = await fetch(ept_events.add, {
      method: 'POST',
      body: formData, 
    });

    const responseJSON = await response.json();
    if(responseJSON.status === 2) {
      add_event_status.innerHTML = `
        <div class = "form-status form-status-success">
          ${__('Success! The event has been succesfully created, you can view it at ', 'e-potis')} <a href = "${responseJSON.url}">${responseJSON.url}</a>
        </div>
      `
    } else {
      add_event_form_fieldset.removeAttribute('disabled')
      add_event_status.innerHTML = `
        <div class ="form-status form-status-danger">
          ${__('Something went wrong', 'e-potis')}
        </div>
      `
    }
  })
})