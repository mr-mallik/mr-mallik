import { fetchData } from '@/lib/mysql';

export async function GET(request) {
  try {
    const profileQuery = "SELECT * FROM profile";
    const profileData = await fetchData(profileQuery);

    const socialQuery = "SELECT * FROM social_links";
    const socialData = await fetchData(socialQuery);

    const profile = profileData[0]

    const data = {
      ...profile,
      social_links: socialData
    }
    
    return new Response(JSON.stringify(data), {
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
