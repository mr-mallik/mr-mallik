"use client";

import { useState, useEffect } from "react";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";
import Image  from 'next/image';
import { convertToRoman } from "@/lib/helper";
import SwipeHandler from '@/components/SwipeHandler';
import { useRouter } from 'next/navigation';
import { motion } from 'framer-motion';

const Block = ({content, urlname, romanNum}) => (
    <div key={`projectdetail-${urlname}`} className="detailed-block flex flex-row justify-between items-center mb-5 overflow-hidden">
        {content.banner_image && content.banner_image !='' ?
            <>
                <div className="icon-container overflow-hidden desktop:h-full w-2/5">
                    <Image src={`/assets/projects/${urlname}/${content.banner_image}` || "https://cdn.pixabay.com/photo/2015/05/26/23/52/technology-785742_1280.jpg"} alt={content.title} className="" width={256} height={200} />
                </div>
                <div className="content-container text-justify p-5 w-3/5">
                    <h5 className="mb-6 font-semibold tracking-widest laptop:text-lg desktop:text-lg">{`${romanNum}. ${content.title}`}</h5>
                    <p className="text-white text-sm mb-5 desktop:text-base" dangerouslySetInnerHTML={{ __html: content.description }}></p>
                </div>
            </>
            :
            <div className="content-container text-justify p-5">
                <h5 className="mb-6 font-semibold tracking-widest laptop:text-lg desktop:text-lg">{`${romanNum}. ${content.title}`}</h5>
                <p className="text-white text-sm desktop:text-base" dangerouslySetInnerHTML={{ __html: content.description }}></p>
            </div>
        }
    </div>
);

function ProjectDetails({ params }) {
    const router = useRouter();
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
                setTimeout(() => setLoading(false), 300);
            }
        };

        fetchProject();
    }, [urlname]);

    const handleSwipeLeft = (nextPageUrlname) => {
        if(nextPageUrlname) {
            router.push(nextPageUrlname); // Replace with your next page route
        }
    };
    
    const handleSwipeRight = (previousPageUrlname) => {
        if(previousPageUrlname) {
            router.push(previousPageUrlname); // Replace with your next page route
        }
    };

    if(isLoading) {
        return (
            <Loader hidden={fadeOut} />
        )
    }
    
    return(
        <SwipeHandler
            onSwipeLeft={() => handleSwipeLeft(project && project.next ? project.next : '')}
            onSwipeRight={() => handleSwipeRight(project && project.previous ? project.previous : '')}
            >
                
            <div className="projects">
                <Navbar activeTab='project' />
                {/* Banner */}
                <div className="projects-banner" style={{ backgroundImage: (project.image) ? `url(/assets/projects/${project.urlname}/${project.banner_image})` : 'url("https://cdn.pixabay.com/photo/2015/05/26/23/52/technology-785742_1280.jpg")' }}>
                    <div className="container mx-auto max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="mt-10 absolute bottom-24 w-2/5 desktop:mt-20">
                            <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">{project.title}</h1>
                        </div>
                    </div>
                </div>
                {/* Content */}
                <motion.div
                    initial={{ scale: 0, rotate: 180 }}
                    animate={{ rotate: 0, scale: 1 }}
                    transition={{
                        type: "spring",
                        stiffness: 260,
                        damping: 20
                    }}
                    >
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
                                    
                                    {/* <div className="mt-2 flex">
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-400  relative -left-2"> VS</div> 
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-600 relative -left-2"> GM</div> 
                                    </div> */}
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
                                <h3 className="font-bold mb-6 tracking-wider underline underline-offset-8 color-tertiary laptop:text-lg desktop:text-xl">tl;dr</h3>
                                <p className="text-white text-sm mb-5 desktop:text-base">
                                    {project.overview}
                                </p>
                            </div>

                            {/* Project Details */}
                            {project && project.projectDetails &&
                                project.projectDetails.map((item, index) => (
                                    <Block key={`block-${index}`} content={item} urlname={project.urlname} romanNum={ convertToRoman( parseInt(index+1) ) } />
                            ))}
                        </div>
                    </div>
                </motion.div>
            </div>
        </SwipeHandler>
    )
}

export default ProjectDetails;