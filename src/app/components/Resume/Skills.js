import Image from 'next/image';
import { motion } from 'framer-motion';

const heading_arr = {
    'tech': 'Programming Languages',
    'frame': 'Framework and Technologies',
    'db': 'Databases',
    'gen': 'General',
    'soft': 'Soft Skills'
}

function Skills({skills}) {

    return (
        <motion.div
            initial={{ x: -100, opacity: 0 }}
            whileInView={{ x: 0, opacity: 1 }}
            transition={{ type: 'tween', duration: 0.5, ease: 'easeInOut' }}
            viewport={{ once: false, amount: 0.5 }}
            className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Skills</h1>

                {skills.map(([type, skillsList]) => {
                        if(skillsList.length == 0) return null;
                        
                        var heading = heading_arr[type];
                        return (
                            <div key={heading}>
                                <h5 className="tracking-widest mb-1">{heading}:</h5>
                                <div className="flex flex-row flex-wrap gap-0 justify-start content-center">
                                {skillsList.map(skill => (
                                    <motion.div
                                        whileHover={{ rotate: 15 }}
                                        className="w-20 text-center px-0 py-2 mb-3 mr-3 bg-gray-800 border rounded border-transparent hover:border-color-tertiary" key={skill.id}>
                                        <Image className="w-10 m-auto" alt={skill.title} title={skill.title} src={skill.icon} width={76} height={76} />
                                        <p className="pt-2 text-xs">{skill.title}</p>
                                    </motion.div> 
                                ))}
                                </div>
                            </div>
                        )
                    })
                }
                
            </div>  
        </motion.div>
    )
}

export default Skills;