"use client";

import { useState, useEffect } from "react";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";
import Image from "next/image";
import { motion } from 'framer-motion';

// Updated Block component to use dynamic content
const Block = ({ content }) => (
    <motion.a 
    initial={{ x: 100, opacity: 0 }}
    whileInView={{ x: 0, opacity: 1 }}
    transition={{ type: 'tween', duration: 0.5, ease: 'easeInOut' }}
    viewport={{ once: false, amount: 0.5 }} 
    href={`/projects/${content.urlname}`} className="diamond-card rounded overflow-hidden bg-gray-900 bg-opacity-8 shadow-md">
        <div className="icon-container overflow-hidden max-h-44 desktop:max-h-52">
            <Image src={`/assets/projects/${content.urlname}/${content.image}` || "https://cdn.pixabay.com/photo/2015/05/26/23/52/technology-785742_1280.jpg"} alt={content.title} className="object-cover" width={640}  height={200} />
        </div>
        <div className="content-container overflow-hidden text-justify p-5 laptop:min-h-ht-175 desktop:min-h-ht-190">
            <h3 className="font-bold-300 mb-2 text-base desktop:text-xl desktop:mt-1">{content.title}</h3>
            <p className="text-gray-400 text-sm mb-5 desktop:text-base">{content.short_description}</p>
            <div className="flex flex-wrap justify-start items-start">
                {content.skill_icons.map((skill, index) => (
                    <img 
                        key={index} 
                        className="mr-2 mb-2 h-6 rounded" 
                        src={skill} 
                        alt=''
                    />
                ))}
            </div>
        </div>
    </motion.a>
);

function Projects() {
    const [projects, setProjects] = useState([]);
    const [isLoading, setLoading] = useState(true);
    const [fadeOut, setFadeOut] = useState(false);

    useEffect(() => {
        const fetchProjects = async () => {
            try {
                const response = await fetch('/api/projects'); // Adjust API endpoint as needed
                const data = await response.json();
                // console.log(data);
                setProjects(data);
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

        fetchProjects();
    }, []);

    return (
        <>
            {isLoading && <Loader hidden={fadeOut} />}
            <div className="projects">
                <Navbar activeTab='home' />
                <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                    <div className="mt-10 desktop:mt-20">
                        <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Projects</h1>
                    </div>
                    <div className="grid grid-cols-1 tablet:grid-cols-2 gap-2 laptop:grid-cols-4 laptop:gap-4 mb-10 mt-10">
                        {projects.map((project) => (
                            <Block key={project.project_id} content={project} />
                        ))}
                    </div>
                </div>
            </div>
        </>
    );
}

export default Projects;