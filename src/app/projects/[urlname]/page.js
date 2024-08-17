"use client";

import { useRouter } from 'next/router';
import { useState, useEffect } from "react";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";
import Image  from 'next/image';

import { fetchData } from '@/lib/mysql';
import { skillQuery, skillIcons } from '@/lib/helper';

// This function gets called at build time
export async function getStaticPaths() {
  // Fetch all possible slugs
  const allProjects = await fetchData('SELECT urlname FROM project');

  // Create paths with `slug` param
  const paths = allProjects.map((project) => ({
    params: { slug: project.urlname }
  }));

  return {
    paths,
    fallback: false // or 'blocking' depending on your needs
  };
}

// This function gets called at build time
export async function getStaticProps({ params }) {
  const { slug } = params;

  try {
    // Fetch necessary data for the project
    const skills = await fetchData(skillQuery);
    const projectQuery = "SELECT * FROM project WHERE urlname = ?";
    const projectData = await fetchData(projectQuery, [slug]);

    if (projectData.length === 0) {
      return {
        notFound: true
      };
    }

    const project = projectData[0];
    project.skill_icons = skillIcons(skills, project);

    const projectDetQuery = "SELECT * FROM project_det WHERE project_id = ?";
    const projectDetData = await fetchData(projectDetQuery, [project.project_id]);

    const data = {
      ...project,
      projectDetails: projectDetData
    };

    return {
      props: {
        project: data
      }
    };
  } catch (error) {
    console.error('Error fetching data:', error);
    return {
      notFound: true
    };
  }
}

const Block = ({content, urlname}) => (
    <div key={`projectdetail-${urlname}`} className="detailed-block flex flex-row justify-between items-center mb-5 overflow-hidden">
        <div className="icon-container overflow-hidden desktop:h-full w-2/5">
            {content.image && 
                <Image src={`/assets/projects/${urlname}/${content.image}`} alt={content.title} className="" width={256} height={200} />
            }

            {/* {content.video_link && 
                <Image src={content.video_link} alt={content.title} className="" />
            } */}
        </div>
        <div className="content-container text-justify p-5 ml-3 w-3/5">
            <h5 className="mb-6 font-semibold tracking-widest laptop:text-lg desktop:text-lg">{content.title}</h5>
            <p className="text-white text-sm mb-5 desktop:text-base">
                {content.description}
            </p>
        </div>
    </div>
);

function ProjectDetails({ params }) {
    const { urlname } = params; // Capture the 'detail' parameter from the URL

    const [project, setProject] = useState([]);
    const [isLoading, setLoading] = useState(true);
    const [fadeOut, setFadeOut] = useState(false);

    useEffect(() => {
        const fetchProject = async () => {
            try {
                const response = await fetch(`/api/projects/${urlname}`); // Adjust API endpoint as needed
                const data = await response.json();
                // console.log(data);
                setProject(data);
                setLoading(false);
            } catch (error) {
                console.error('Failed to fetch projects', error);
                setLoading(false);
            }
            finally {
                setFadeOut(true);
                setTimeout(() => setLoading(false), 500);
            }
        };

        fetchProject();
    }, [urlname]);
    
    return(
        <>
            {isLoading && <Loader hidden={fadeOut} />}
            <div className="projects">
                <Navbar activeTab='project' />
                {/* Banner */}
                <div className="projects-banner" style={{ backgroundImage: `url(/assets/projects/${project.urlname}/${project.banner_image})` }}>
                    <div className="container mx-auto max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="mt-10 absolute bottom-24 w-2/5 desktop:mt-20">
                            <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">{project.title}</h1>
                        </div>
                    </div>
                </div>
                {/* Content */}
                <div className="">
                    <div className="container mx-auto max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="relative -top-16 rounded-lg pb-10 pt-12 px-10 bg-gray-900">
                            {/* Minor Details */}
                            <div className="mb-8 flex justify-between items-start">
                                <div>
                                    <div className="flex flex-wrap justify-start items-start">
                                    {project.skill_icons && 
                                        project.skill_icons.map((skill, index) => {
                                            return(
                                                <img key={`skill-icon-${index}`} className="mr-2 mb-2 h-6 rounded" src={skill} />
                                            )
                                        })
                                    }
                                    </div>
                                    
                                    <div className="mt-2 flex">
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-400  relative -left-2"> VS</div> 
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-600 relative -left-2"> GM</div> 
                                    </div>
                                </div>
                                <div className="">
                                    {project.github &&
                                        <a href={project.github} target='_blank' className="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 
                                        focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 text-center me-2 
                                        mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">View on Github</a>
                                    }

                                    {project.online &&
                                        <a href={project.online} target='_blank' className="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4
                                        focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:bg-gray-800
                                        dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Online</a>
                                    }

                                    {project.user_guide &&
                                        <a href={project.user_guide} className="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4
                                        focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:bg-gray-800
                                        dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">View User Manual</a>
                                    }
                                </div>
                            </div>
                            
                            
                            {/* Summary block */}
                            <div className="bg-gray-800 p-5 rounded mb-8 text-justify">
                                <h3 className="font-bold mb-6 tracking-wider underline underline-offset-8 color-tertiary laptop:text-lg desktop:text-xl">Overview</h3>
                                <p className="text-white text-sm mb-5 desktop:text-base">
                                    {project.overview}
                                </p>
                            </div>

                            {/* Project Details */}
                            {project && project.projectDetails &&
                                project.projectDetails.map((item, index) => (
                                    <Block key={`block-${index}`} content={item} urlname={project.urlname} />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default ProjectDetails;