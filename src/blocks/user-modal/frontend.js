document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.querySelectorAll('.open-user-modal')
    const modalEl = document.querySelector('.wp-block-ept-user-flow-user-modal')
    const modalCloseEl = document.querySelectorAll(
        '.modal-overlay, .modal-btn-close'
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

})