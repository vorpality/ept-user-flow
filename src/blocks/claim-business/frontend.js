document.addEventListener('DOMContentLoaded', () => {
  const claimForm = document.querySelector('#own-business-form');

  claimForm?.addEventListener('submit', async event => {
    event.preventDefault();

    const business_data = document.querySelector('#business-data');
    const business_id = business_data.getAttribute('data-place-id');
    const user_id = business_data.getAttribute('data-user-id');

    const formData = {
      user_id:user_id,
      buisness_id:business_id
    }

    try {
      const response = await fetch('/ept/v1/claim-business', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ formData })
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
