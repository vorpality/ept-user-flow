import {__} from '@wordpress/i18n'
document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.querySelectorAll('.open-auth-modal')
    const modalEl = document.querySelector('.wp-block-ept-user-flow-auth-modal')
    const modalCloseEl = document.querySelectorAll(
        '.wp-block-ept-user-flow-auth-modal .modal-overlay,.wp-block-ept-user-flow-auth-modal .modal-btn-close'
    )
  
    openModalBtn.forEach( el => {
        el.addEventListener('click', event => {
            event.preventDefault()
            modalEl.classList.add('modal-show') 
        })
    })
  
    modalCloseEl.forEach( el => {
        el.addEventListener('click', event => {
            event.preventDefault()
            modalEl.classList.remove('modal-show')
        })
    }) 
  
    const tabs = document.querySelectorAll('.tabs a') 
    const signinForm = document.querySelector('#signin-tab')
    const signupForm = document.querySelector('#signup-tab')
  
    tabs.forEach( tab => {
        tab.addEventListener('click', event => {
            event.preventDefault()
  
            tabs.forEach( currentTab => {
                currentTab.classList.remove('active-tab')
            })
            event.currentTarget.classList.add('active-tab')
            const activeTab = event.currentTarget.getAttribute('href')
  
            if(activeTab === '#signin-tab'){
                signupForm.style.display = 'none'
                signinForm.style.display = 'block'
            } else {
                signinForm.style.display = 'none'
                signupForm.style.display = 'block'
            }
        })  
    })
    
    signupForm?.addEventListener('submit', async event => {
        event.preventDefault()
  
        const signupFieldset = signupForm.querySelector('fieldset')
   
        signupFieldset.setAttribute('disabled', true)
  
        const signupStatus = signupForm.querySelector('#signup-status')
        signupStatus.innerHTML = ` 
            <div class ="modal-status modal-status-info">
                ${__('Please wait! We are processing your request.', 'e-potis')}
            </div>
        `   
        const formData = {
            username: signupForm.querySelector('#su-name').value,
            email: signupForm.querySelector('#su-email').value,
            password: signupForm.querySelector('#su-password').value,
            business_owner: signupForm.querySelector('#su-business-owner').checked,
            newsletter: signupForm.querySelector('#su-newsletter').checked
        }
  
        const response = await fetch(ept_auth_rest.signup, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
  
        const responseJSON = await response.json();
  
        if(responseJSON.status === 2) {
            signupStatus.innerHTML = `
                <div class = "modal-status modal-status-success">
                    ${__('Success! You have changed your data succesfully', 'e-potis')}
                </div>
            `
            location.reload()
        } else {
            signupFieldset.removeAttribute('disabled')
            signupStatus.innerHTML = `
            <div class ="modal-status modal-status-danger">
            ${__('Unable to create account! Please try again later.', 'e-potis')}
            </div>
            `
        }
    })
  
    signinForm?.addEventListener('submit', async event =>{
        event.preventDefault()
  
        const signinFieldset = signinForm.querySelector('fieldset')
  
        signinFieldset.setAttribute('disabled', true)
  
        const signinStatus = signinForm.querySelector('#signin-status')
        signinStatus.innerHTML = `
            <div class ="modal-status modal-status-info">
                ${__('Please wait! We are trying to log you in.','e-potis')}
            </div>
        `   
  
        const formData = {
            user_login: signinForm.querySelector('#si-email').value,
            password: signinForm.querySelector('#si-password').value
        }
  
        const response = await fetch(ept_auth_rest.signin, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const responseJSON = await response.json();
  
        if(responseJSON.status === 2) {
            signinStatus.innerHTML = `
                <div class = "modal-status modal-status-success">
                   ${__('Success! You are now logged in.','e-potis')}
                </div>
            `
            location.reload()
        } else {
            signinFieldset.removeAttribute('disabled')
            signinStatus.innerHTML = `
            <div class ="modal-status modal-status-danger">
            ${__('Invalid credentials! Please try again later.','e-potis')}
            </div>
            `
        }
    })
  })