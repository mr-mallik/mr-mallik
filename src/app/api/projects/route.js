import { fetchData } from '@/lib/mysql';
import { skillQuery, skillIcons } from '@/lib/helper';

export async function GET(request) {

  try {
    const skills = await fetchData(skillQuery);

    // Query to fetch project details based on project ID
    const query = "SELECT * FROM project ORDER BY `published_date` DESC";
    const data = await fetchData(query);

    if (data.length === 0) {
      return new Response(JSON.stringify({ error: 'No projects found' }), {
        status: 404,
        headers: {
          'Content-Type': 'application/json'
        }
      });
    }

    const data_set = (data || []).map(projectItem => {
      const skillIconList = skillIcons(skills, projectItem);
      projectItem.skill_icons = skillIconList; // Directly assign the list instead of pushing to an existing array

      return projectItem;
    });

    return new Response(JSON.stringify(data_set), {
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