'use client';

import { useEffect, useState } from "react";

import Navbar from "../components/Navbar"
import Loader from "../components/Loader"

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
            console.log('service_data:', service_data);
            setService(service_data);
            
        } catch (error) {
            console.error('Fetch profile failed:', error);
        }
        finally {
            setFadeOut(true);
            setTimeout(() => setLoading(false), 500);
        }
    };
  
    useEffect(() => {
        fetchAbout();
    }, [])

    return (
        <>
        {isLoading && <Loader hidden={fadeOut} />}
        <div className='about-page h-screen overflow-hidden bg-black text-white bg-right bg-no-repeat'>
            <Navbar activeTab="about" />
            <div className="container mx-auto h-screen max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                <div className="flex flex-col">
                    <div className="flex flex-col gap-10 mt-10 laptop:w-2/3 desktop:mt-20 desktop:w-6/12">
                        <div className="flex flex-col gap-2">
                            <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">About</h1>
                            <div className="px-0">
                                <p className='text-base desktop:text-lg'>{profile.about_me}</p>
                            </div>
                        </div>
                    </div>
                    <div className="w-2/3 mt-10 desktop:mt-20">
                        <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">What I Do</h1>
                        <div className="flex flex-nowrap justify-between mt-10">
                            {service && service.length > 0 &&
                                service.map((ser, idx) => {
                                    return(
                                        <div className="mr-4" key={idx}>
                                            <div className="diamond-card rounded overflow-hidden bg-gray-800 shadow-md">
                                                <div className="icon-container overflow-hidden max-h-28 desktop:max-h-32">
                                                    <img src={ser.image} alt="Website Icon" className="" />
                                                </div>
                                                <div className="content-container overflow-hidden laptop:min-h-ht-175 desktop:min-h-ht-190">
                                                    <h3 className="font-bold text-center mt-2 mb-2 text-base desktop:text-2xl desktop:mt-4">{ser.title}</h3>
                                                    <p className="text-gray-400 text-center text-sm pb-2 px-2 desktop:text-base">{ser.description}</p>
                                                </div>
                                            </div>
                                        </div>
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