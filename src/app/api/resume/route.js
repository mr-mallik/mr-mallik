import { fetchData } from '../../../lib/mysql';

export async function GET(request) {
  try {
    const skills = await fetchData(`SELECT * 
    FROM skills 
    ORDER BY 
        CASE 
            WHEN type = 'tech' THEN 1
            WHEN type = 'frame' THEN 2
            WHEN type = 'db' THEN 3
            WHEN type = 'gen' THEN 4
            WHEN type = 'soft' THEN 5
            ELSE 6
        END ASC, 
        rank ASC`);
    const resume = await fetchData("SELECT *, date_format(end, '%Y') as end_year, date_format(start, '%Y') as start_year, date_format(start, '%b %Y') as start_my, date_format(end, '%b %Y') as end_my FROM resume WHERE status = 'A' ORDER BY type asc, end DESC");

    // Group skills by type using an object
    const skill_set = skills.reduce((acc, skill) => {
      if (!acc[skill.type]) {
        acc[skill.type] = [];
      }

      if(skill.featured == 1) {
        acc[skill.type].push(skill);
      }
      return acc;
    }, {});

    // Group resumes by type using an object
    const resume_set = resume.reduce((acc, resume_item) => {
      if (!acc[resume_item.type]) {
        acc[resume_item.type] = [];
      }
      acc[resume_item.type].push(resume_item);
      return acc;
    }, {});

    // Create a Map for skill IDs to icons for quick lookup
    const skill_map = new Map(skills.map(skill => [skill.id, skill.icon_pill]));

    // Process work items
    const work_set = (resume_set.work || []).map(work_item => {
      // Convert skills to an array and trim whitespace
      const skills_arr = work_item.skills.split(',').map(skill => skill.trim());

      // Initialize skill_icons if not already present
      if (!work_item.skill_icons) {
        work_item.skill_icons = [];
      }

      // Add icons for each skill present in the skill_map
      skills_arr.forEach(skill_id => {
        const icon_pill = skill_map.get( parseInt(skill_id) );
        
        if (icon_pill) {
          work_item.skill_icons.push(icon_pill);
        }
      });

      return work_item;
    });


    var data = {
        'skills': Object.entries(skill_set),
        'education': resume_set.edu,
        'hobbies': resume_set.hobby,
        'work': work_set,
        'certifications': resume_set.cert
    };
    
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
