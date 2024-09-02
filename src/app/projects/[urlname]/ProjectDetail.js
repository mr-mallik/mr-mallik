"use client";

import Image  from 'next/image';
import { convertToRoman } from "@/lib/helper";
import SwipeHandler from '@/components/SwipeHandler';
import { useRouter } from 'next/navigation';
import { motion } from 'framer-motion';
import { FaGithub, FaLink, FaBook } from 'react-icons/fa';

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

function ProjectDetail({ project }) {
    const router = useRouter();

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
 
    return(
        <SwipeHandler
            onSwipeLeft={() => handleSwipeLeft(project && project.next ? project.next : '')}
            onSwipeRight={() => handleSwipeRight(project && project.previous ? project.previous : '')}
            >

            <div className="projects">
                {/* Banner */}
                <div className="projects-banner" style={{ backgroundImage: (project.image) ? `url(/assets/projects/${project.urlname}/${project.banner_image})` : 'url("https://cdn.pixabay.com/photo/2015/05/26/23/52/technology-785742_1280.jpg")' }}>
                    <div className="container mx-auto max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="mt-10 absolute px-5 tablet:px-0 z-20 bottom-24 w-full tablet:w-2/5 desktop:mt-20">
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
                        <div className="relative z-30 -top-16 rounded-lg pb-10 pt-12 px-4 tablet:px-10 bg-gray-900">
                            {/* Minor Details */}
                            <div className="mb-8 flex justify-between items-start">
                                <div>
                                    <div className="flex flex-wrap justify-start items-start">
                                    {project.skill_icons && 
                                        project.skill_icons.map((skill, index) => {
                                            return(
                                                <img key={`skill-icon-${index}`} alt="" className="mr-2 mb-2 h-6 rounded" src={skill} />
                                            )
                                        })
                                    }
                                    </div>
                                    
                                    {/* <div className="mt-2 flex">
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-400  relative -left-2"> VS</div> 
                                        <div className="authors w-10 h-10 rounded-full text-center px-0 py-2 bg-gray-600 relative -left-2"> GM</div> 
                                    </div> */}
                                </div>
                                <div className="flex">
                                    {project.github &&
                                        <a target="_blank" title='View on GitHub' href={project.github} className="bg-black h-9 text-xs rounded-lg p-2 me-2 mb-2">
                                            <FaGithub size={20} />
                                        </a>
                                    }

                                    {project.online &&                                        
                                        <a target="_blank" title='View Demo' href={project.github} className="bg-gray-600  h-9 text-xs rounded-lg p-2 me-2 mb-2">
                                            <FaLink size={20} />
                                        </a>
                                    }

                                    {project.user_guide &&
                                        <a target="_blank" title='Read More' href={project.github} className="bg-yellow-700 h-9 text-xs rounded-lg p-2 me-2 mb-2">
                                            <FaBook size={20} />
                                        </a>
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

export default ProjectDetail;