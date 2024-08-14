"use client";

import { useRouter } from 'next/router';
import { useState, useEffect } from "react";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";

const Block = ({content}) => (
    <div className="detailed-block flex flex-row justify-between items-center mb-5 overflow-hidden">
        <div className="icon-container overflow-hidden desktop:h-full w-2/5">
            <img src="https://cdn.pixabay.com/photo/2016/06/28/05/10/laptop-1483974_960_720.jpg" alt="Website Icon" className="" />
        </div>
        <div className="content-container text-justify p-5 ml-3 w-3/5">
            <h5 className="mb-6 font-semibold tracking-widest laptop:text-lg desktop:text-lg">Screen Name</h5>
            <p className="text-white text-sm mb-5 desktop:text-base">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap 
            into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
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
                console.log(data);
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
    }, []);
    
    return(
        <>
            {isLoading && <Loader hidden={fadeOut} />}
            <div className="projects">
                <Navbar activeTab='home' />
                {/* Banner */}
                <div className="projects-banner">
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
                                                <img className="mr-2 mb-2 h-6 rounded" src={skill} />
                                            )
                                        })
                                    }
                                    </div>
                                    
                                    <div className="mt-2 flex">
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-400  relative -left-2"> VS</div> 
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-600 relative -left-2"> GM</div> 
                                    </div>
                                </div>
                                <div class="">
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
                            {project && project.ProjectDetails &&
                                project.ProjectDetails.map((item, index) => (
                                    <Block key={index} content={item} />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default ProjectDetails;