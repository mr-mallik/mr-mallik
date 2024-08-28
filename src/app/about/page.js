'use client';

import { useEffect, useState } from "react";

import Navbar from "@/components/Navbar"
import Loader from "@/components/Loader"
import Image from 'next/image';
import { motion } from 'framer-motion';

export default function About() {
    const[isLoading, setLoading] = useState(true);
    const[profile, setProfile] = useState(false);
    const[service, setService] = useState(false);
    const[fadeOut, setFadeOut] = useState(false);
    
    const fetchAbout = async () => {
        try {
            const my_profile = await fetch('/api/profile');
            if (!my_profile.ok) {
                throw new Error('Network my_profile was not ok');
            }
            const profile_data = await my_profile.json();
            setProfile(profile_data);

            const my_service = await fetch('/api/service');
            if (!my_service.ok) {
                throw new Error('Network my_service was not ok');
            }
            const service_data = await my_service.json();
            setService(service_data);
            
        } catch (error) {
            console.error('Fetch profile failed:', error);
        }
        finally {
            setFadeOut(true);
            setTimeout(() => setLoading(false), 300);
        }
    };
  
    useEffect(() => {
        fetchAbout();
    }, [])

    return (
        <>
        {isLoading && <Loader hidden={fadeOut} />}
        <div className="about-page h-auto overflow-hidden bg-black text-white bg-right bg-no-repeat laptop:h-screen desktop:h-screen">
            <Navbar activeTab="about" />
            <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                <div className="flex flex-col">
                    <motion.div 
                    initial={{ opacity: 0, y: 300 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5, ease: "easeInOut" }}
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
                </div>
            </div>
        </div>
        </>
    )
}