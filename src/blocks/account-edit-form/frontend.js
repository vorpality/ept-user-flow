import {__} from '@wordpress/i18n'


document.addEventListener('DOMContentLoaded', () => {

  const data_replace_form = document.querySelector('#data-replace-form')


  
  data_replace_form?.addEventListener('submit', async event => {
        event.preventDefault();
        

        const data_form_fieldset = data_replace_form.querySelector('fieldset')
        data_form_fieldset.setAttribute('disabled', true)



      const data_replace_status = data_replace_form.querySelector('#form-status')
      data_replace_status.innerHTML = `
          <div class ="modal-status modal-status-info">
          ${__('Please wait! We are processing your request.', 'e-potis')}
          </div>
      `   
        const email = data_replace_form.querySelector('#dr-email').value
        const old_pass=data_replace_form.querySelector('#dr-old-password').value;
        const new_pass=data_replace_form.querySelector('#dr-new-password').value;
        const verify_pass=data_replace_form.querySelector('#dr-verify-password').value;
        const newsletter = data_replace_form.querySelector('#dr-newsletter').value
        const id = data_replace_form.querySelector('#user-id').value;
        if( new_pass &&
          (old_pass!=new_pass ||
          new_pass!=verify_pass ||
          new_pass.length<8)
        )
        {
          event.preventDefault();
          data_form_fieldset.removeAttribute('disabled')
          data_replace_status.innerHTML = `
          <div class ="form-status form-status-danger">
            ${__('The passwords entered do not match or are not at least 8 characters.', 'e-potis')}
          </div>
          `
        }    
        const formData = {
            user_id:id,
            user_email: email,
            user_old_password:old_pass,
            user_new_password:new_pass,
            user_newsletter: newsletter
          }

        const response = await fetch(ept_account_edit.replace, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const responseJSON = await response.json();
      if(responseJSON.status === 2) {
        
          data_replace_status.innerHTML = `
              <div class = "form-status form-status-success">
                ${__('Success! You have changed your data succesfully', 'e-potis')}
              </div>`
          
              location.reload()
      } else {
        data_form_fieldset.removeAttribute('disabled')
          data_replace_status.innerHTML = `
          <div class ="form-status form-status-danger">
            ${__('Something went wrong', 'e-potis')}
          </div>
          `
      }
  })
})