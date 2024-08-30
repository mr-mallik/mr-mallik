import { fetchData } from '@/lib/mysql';
import { skillQuery, skillIcons } from '@/lib/helper';

export async function GET(request, { params }) {
  const { slug } = params; // Extract the project URL name from the URL params
  try {
    const skills = await fetchData(skillQuery);

    // Query to get project data based on slug
    const projectQuery = "SELECT * FROM project WHERE urlname = ?";
    const projectData = await fetchData(projectQuery, [slug]);

    // If no project data found
    if (projectData.length === 0) {
      return new Response(JSON.stringify({ error: 'No details found for this project' }), {
        status: 404,
        headers: {
          'Content-Type': 'application/json'
        }
      });
    }

    const project = projectData[0];

    const prevUrl = await fetchData("SELECT urlname FROM `project` WHERE `project_id` = ?", [(project.project_id - 1)] );
    const nextUrl = await fetchData("SELECT urlname FROM `project` WHERE `project_id` = ?", [(project.project_id + 1)] );

    if(prevUrl && prevUrl[0]) project.previous = prevUrl[0]['urlname'];
    if(nextUrl && nextUrl[0]) project.next = nextUrl[0]['urlname'];

    // Process work items
    project.skill_icons = skillIcons(skills, project);
    
    // Query to get project details based on project ID
    const projectDetQuery = "SELECT * FROM project_det WHERE project_id = ?";
    const projectDetData = await fetchData(projectDetQuery, [project.project_id]);

    // Combine project and project details data
    const data = {
      ...project,
      projectDetails: projectDetData
    };

    // console.log(data);

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