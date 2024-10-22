import Loader from "@/components/Loader";
import { fetchAPI } from "@/lib/fetchAPI";
import dynamic from "next/dynamic";

const Navbar = dynamic(() => import("@/components/Navbar"), {ssr: false});
const ProjectDetail = dynamic(() => import("./ProjectDetail"), {ssr: false});

async function fetchProjectData(urlname) {
    const { data, error } = await fetchAPI(`${process.env.BASE_URL}/api/projects/${urlname}`);
    
    if (error) {
      console.error('Error fetching project data:', error);
      // Return default data or handle error appropriately
      return {
        name: 'Default Project',
        description: 'Default description',
        keywords: ['Default', 'Project'],
        image: `${process.env.BASE_URL}/assets/images/seo-image.png`,
      };
    }
    
    return data;
  }

export async function generateMetadata({ params }) {
    // Fetch project data based on dynamic parameters
    const projectData = await fetchProjectData(params.urlname); // Replace with your data fetching logic
    
    // Return metadata based on project data
    return {
      title: `${projectData.title}`,
      description: projectData.seo_desc || "Explore projects developed by Gulger Mallik, including innovative solutions and advanced systems.",
      keywords: projectData.seo_keyword,
      openGraph: {
        title: `${projectData.title}`,
        description: projectData.short_description,
        url: `${process.env.BASE_URL}/projects/${projectData.urlname}`,
        images: [
          {
            url: `${process.env.BASE_URL}/assets/projects/${projectData.urlname}/${projectData.image || `${process.env.BASE_URL}/assets/images/seo-image.png`}`,
            width: 800,
            height: 600,
          },
        ],
      },
      twitter: {
        card: 'summary_large_image',
        title: `${projectData.title}`,
        description: projectData.short_description,
        images: [`${process.env.BASE_URL}/assets/projects/${projectData.urlname}/${projectData.image || `${process.env.BASE_URL}/assets/images/seo-image.png`}`],
      },
    };
}

async function ProjectDetails({ params }) {
    try {
        const project = await fetchProjectData(params.urlname);

        if(!project) {
            return <Loader />
        }

        const jsonLd = {
          "@context": "https://schema.org",
          "@type": "Project",
          "url": `${process.env.BASE_URL}`,
          "name": project.title,
          "image": `${process.env.BASE_URL}/assets/projects/${project.urlname}/${project.image || `${process.env.BASE_URL}/assets/images/seo-image.png`}`,
          "description": project.short_description,
          "owns": {
            "@type": "Person",
            "name": "Gulger Mallik"
          }
        }

        return (
            <>
                <script
                      type="application/ld+json"
                      dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
                  />
                <Navbar activeTab='project' />
                <ProjectDetail project={project} />
            </>
        )
    }
    catch (err) {
        console.error("An error occurred while rendering projects");
        throw err;
    }
}

export default ProjectDetails;