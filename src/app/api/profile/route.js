import { fetchData } from '../../../lib/mysql';

export async function GET(request) {
  try {
    const query = "SELECT * FROM profile";
    const data = await fetchData(query);
    
    return new Response(JSON.stringify(data[0]), {
      status: 200,
      headers: {
        'Content-Type': 'application/json'
      }
    });
  } catch (error) {
    console.error('API Route Error:', error);
    return new Response(JSON.stringify({ error: 'Failed to fetch data' }), {
      status: 500,
      headers: {
        'Content-Type': 'application/json'
      }
    });
  }
}
