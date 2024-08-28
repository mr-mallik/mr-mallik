import { motion } from 'framer-motion';

const itemWidth = [
    'w-10/12',
    'w-9/12'
]

function Education({education}) {
    
    return (
        <motion.div 
        initial={{ x: 100, opacity: 0 }}
        whileInView={{ x: 0, opacity: 1 }}
        transition={{ type: 'tween', duration: 0.5, ease: 'easeInOut' }}
        viewport={{ once: false, amount: 0.5 }}
        className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Education</h1>
                <div className="my-2 clear-both">
                    {education.map((edu, index) => {
                        var classWidth = itemWidth[index];
                            return(
                                <motion.div 
                                whileHover={{
                                    scale: 1.2,
                                    transition: { duration: 0.5 },
                                }}
                                className={`${classWidth} py-4 pr-5 pl-8 mr-0 laptop:pl-28 mb-4 laptop:mr-3 relative float-right bg-gray-900 rounded border-r-4 border-r-color-tertiary`} key={edu.id}> 
                                    <h3 className="absolute text-gray-500 -rotate-90 text-opacity-60 text-4xl -left-12 laptop:rotate-0 laptop:text-6xl font-extrabold laptop:-left-16 flex justify-center items-center top-1/2 -translate-y-1/2">{edu.end_year}</h3>
                                    <h6 className="text-lg laptop:text-2xl mb-3">{edu.title}</h6>
                                    <p className="text-base laptop:text-lg pt-4 mb-1">{edu.subtitle}</p>
                                    <p className="text-base laptop:text-lg">{edu.content} </p>
                                </motion.div> 
                            )
                        })
                    }
                </div>
            </div>  
        </motion.div>
    )
}

export default Education;