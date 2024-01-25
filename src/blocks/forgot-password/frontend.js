import {__} from '@wordpress/i18n'
document.addEventListener('DOMContentLoaded', () => {
    const formEl = document.querySelector('#reset-form')

   
  
    
    formEl?.addEventListener('submit', async event => {
        event.preventDefault()
  
        const formFieldset = formEl.querySelector('fieldset')
  
        formFieldset.setAttribute('disabled', true)
        
        const submitStatus = formEl.querySelector('#submit-status')
        submitStatus.innerHTML = `
            <div class ="submit-status submit-status-info">
                ${__('Please wait! We are processing your request.','e-potis')}
            </div>
        `   
      
        const formData = {
            email: formEl.querySelector('#f-email').value,
        }
  
        const response = await fetch(ept_pwt_rest.forgot, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
  
        const responseJSON = await response.json();
  
        if(responseJSON.status === 2) {
            submitStatus.innerHTML = `
                <div class = "submit-status submit-status-success">
                    ${__('An email has been sent to the address provided.','e-potis')}
                </div>
            `
            //location.reload()
        } else {
            formFieldset.removeAttribute('disabled')
            submitStatus.innerHTML = `
            <div class ="submit-status submit-status-danger">
                ${__('Unable to send email! Please try again later.','e-potis')}
            </div>
            `
        }
    })
  
       
  })