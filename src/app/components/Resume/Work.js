"use client";
import { calculateDateDifference } from '@/lib/helper';
import { motion } from "framer-motion"

function Work({work}) {
    
    return(
        <div 
        className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Experience</h1>

                <div className="experience-container px-0">
                    {work.map((exp, idx) => {
                        var duration = calculateDateDifference(exp.start, exp.end);
                        return(
                            <motion.div
                            initial={{ x: 100, opacity: 0 }}
                            whileInView={{ x: 0, opacity: 1 }}
                            transition={{ type: 'tween', duration: 0.5, ease: 'easeInOut' }}
                            viewport={{ once: false, amount: 0.5 }} 
                            className="experience-block relative pl-12 pb-5 pt-5" key={`work_${exp.id}`}>
                                <h3 className="absolute right-0 top-5 text-lg tablet:text-4xl text-gray-500 italic px-0 tablet:px-4 pb-4">{duration}</h3>
                                <h5 className="-ml-14 mr-3 inline-block relative px-2 py-1 text-8px tablet:text-sm border rounded bg-gray-800 border-gray-500">{`${exp.start_my} - ${exp.end_my}`}</h5>
                                
                                <div className="pt-2"> 
                                    <h4 className="text-lg tablet:text-xl pb-1 pt-2">{exp.title}</h4>
                                    <h6 className="text-xs tablet:text-sm mb-7">{exp.subtitle}</h6>
                                    <div className="flex flex-wrap justify-start items-start">
                                    {exp.skill_icons.map((icon, idx) => {
                                        return(
                                            <img className="mr-2 mb-2 rounded h-5 tabelt:h-auto" src={icon} alt="" key={`icon_${idx}`} />
                                        )
                                    })}
                                    </div>
                                </div>
                            </motion.div>
                        )
                    })}
                </div>
            </div>  
        </div>
    )
}

export default Work;