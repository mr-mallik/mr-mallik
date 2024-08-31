"use client";

import Image from "next/image";
import { motion } from 'framer-motion';

function ProjectBox({project}) {
    return  (
        <motion.a 
                initial={{ x: 100, opacity: 0 }}
                whileInView={{ x: 0, opacity: 1 }}
                transition={{ type: 'tween', duration: 0.5, ease: 'easeIn' }}
                viewport={{ once: true, amount: 0.5 }} 
                href={`/projects/${project.urlname}`} className="diamond-card rounded overflow-hidden bg-gray-900 bg-opacity-8 shadow-md">
                
                <div className="icon-container overflow-hidden max-h-44 desktop:max-h-52">
                    <Image src={ (project.image) ? `/assets/projects/${project.urlname}/${project.image}` : "https://cdn.pixabay.com/photo/2015/05/26/23/52/technology-785742_1280.jpg" } alt={project.title} className="object-cover" width={640}  height={200} />
                </div>
                <div className="project-container overflow-hidden text-justify p-5 laptop:min-h-ht-175 desktop:min-h-ht-190">
                    <h3 className="font-bold-300 mb-2 text-base desktop:text-xl desktop:mt-1">{project.title}</h3>
                    <p className="text-gray-400 text-sm mb-5 desktop:text-base">{project.short_description}</p>
                    <div className="flex flex-wrap justify-start items-start">
                        {project.skill_icons.map((skill, index) => (
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
    )
}

export default ProjectBox;