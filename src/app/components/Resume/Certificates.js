"use client";
import Image from 'next/image';
import { motion } from "framer-motion"

function Certificates({certificates}) {
    return (
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Certificates</h1>
                <div className="mb-2 grid grid-cols-1 tablet:grid-cols-2 gap-2 laptop:grid-cols-4 laptop:gap-4 justify-between content-center">
                    {certificates.map((cert, idx) => {
                        return(
                            <motion.div 
                            initial={{ y: 100, opacity: 0 }}
                            whileInView={{ y: 0, opacity: 1 }}
                            transition={{ type: 'tween', duration: 0.5, ease: 'easeInOut', delay: idx * 0.1 }}
                            viewport={{ once: false, amount: 0.5 }} 
                            className="flex flex-nowrap justify-center content-center px-2 p-2 bg-gray-800 border rounded border-transparent hover:border-color-tertiary" key={`certificate_${cert.id}`}>
                                {cert.logo &&
                                    <Image className="w-16 h-16" alt={cert.title} title={cert.title} src={cert.logo} width={76} height={76} />
                                }
                                <div className="ml-3 my-1 w-3/4">
                                    <h3 className="text-sm tablet:text-base">{cert.title}</h3>
                                    <h6 className="text-xs tablet:text-sm italic mb-2">Issued By: {cert.subtitle}</h6>
                                    <p className="pt-2 text-8px tablet:text-xs">Date: {cert.end_my}</p>
                                </div>
                            </motion.div>
                        )
                    })}
                </div>
            </div>
        </div>
    )
}

export default Certificates;