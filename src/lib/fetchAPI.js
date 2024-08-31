export async function fetchAPI(url, options = {}) {
    try {
        const api_url = process.env.BASE_URL + url
      // Perform the fetch request
      const response = await fetch(api_url, options);
  
      // Check if the response status is OK (status in the range 200-299)
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status} - ${response.statusText}`);
      }
  
      // Parse and return JSON response
      const data = await response.json();
      return { data, error: null };
    } catch (err) {
      // Log the error for debugging
      console.error('Fetch error:', err);
  
      // Return error details
      return { data: null, error: err.message || 'An unknown error occurred' };
    }
  }
  