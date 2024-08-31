'use client';

import Loader from "@/components/Loader"
import Image from 'next/image';
import { motion } from 'framer-motion';
import { Suspense } from "react";

export default function AboutMe({profile, service}) {
    return (
        <Suspense fallback={<Loader />}>
            <motion.div 
            initial={{ opacity: 0, y: 700 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1, ease: "easeInOut" }}
            className="flex flex-col gap-10 mt-10 laptop:w-2/3 desktop:mt-20 desktop:w-6/12">
                <div className="flex flex-col gap-2">
                    <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">About</h1>
                    <div className="px-0">
                        <p className='text-base text-justify desktop:text-lg desktop:text-left'>{profile.about_me}</p>
                    </div>
                </div>
            </motion.div>
            <div className="w-full mt-10 laptop:w-2/3 desktop:mt-20 desktop:w-2/3">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">What I Do</h1>
                <div className="block flex-nowrap justify-between mt-10 laptop:flex">
                    {service && service.length > 0 &&
                        service.map((ser, idx) => {
                            return(
                                <motion.div 
                                    initial={{ opacity: 0, y: -200 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    transition={{ duration: 0.5, ease: "easeOut" }}
                                    whileHover={{ scale: 1.05, boxShadow: "0px 4px 20px rgba(255, 255, 255, 0.2)" }}
                                    className="mr-0 mb-5 laptop:mr-4" key={idx}>
                                    <div className="diamond-card rounded overflow-hidden bg-gray-800 shadow-md">
                                        <div className="icon-container overflow-hidden max-h-40 laptop:max-h-24 desktop:max-h-32">
                                            <Image src={ser.image} alt={ser.title} className="w-full desktop:h-32" width={256} height={200} />
                                        </div>
                                        <div className="content-container py-2 overflow-hidden laptop:min-h-ht-175 laptop:py-0 desktop:min-h-ht-190">
                                            <h3 className="font-bold text-center mt-2 mb-2 text-lg laptop:text-base desktop:text-2xl desktop:mt-4">{ser.title}</h3>
                                            <p className="text-gray-400 text-center pb-2 px-2 text-base laptop:text-sm desktop:text-base">{ser.description}</p>
                                        </div>
                                    </div>
                                </motion.div>
                            )  
                        })
                    }
                </div>
            </div>
        </Suspense>
    )
}