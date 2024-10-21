import { fetchData } from '@/lib/mysql';
import { skillQuery, skillIcons } from '@/lib/helper';

export async function GET(request) {
  try {
    const skills = await fetchData(skillQuery);
    const resume = await fetchData("SELECT *, date_format(end, '%Y') as end_year, date_format(start, '%Y') as start_year, date_format(start, '%b %Y') as start_my, date_format(end, '%b %Y') as end_my FROM resume WHERE status = 'A' ORDER BY type asc, (end IS NULL) DESC, end DESC");

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

    // Process work items
    const work_set = (resume_set.work || []).map(workItem => {
      const skillIconList = skillIcons(skills, workItem);
      workItem.skill_icons = skillIconList; // Directly assign the list instead of pushing to an existing array

      return workItem;
    });


    var data = {
        'skills': Object.entries(skill_set),
        'education': resume_set.edu,
        'hobbies': resume_set.hobby,
        'work': work_set,
        'other': resume_set.other,
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
