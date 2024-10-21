"use client";

import { useState, useEffect } from "react";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";
import SocialLinks from "@/components/SocialLinks";
import { motion } from 'framer-motion';

export default function Home() {
  const[isLoading, setLoading] = useState(true);
  const [profile, setProfile] = useState([]);
  const [fadeOut, setFadeOut] = useState(false);

  const fetchProfile = async () => {
      try {
          const response = await fetch('/api/profile');
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          const data = await response.json();
          setProfile(data);
      } catch (error) {
          console.error('Fetch profile failed:', error);
      }
      finally {
        setFadeOut(true);
        setTimeout(() => setLoading(false), 300);
      }
  };

  useEffect(() => {
    fetchProfile();
  }, [])

  return (
    <>
      {isLoading && <Loader hidden={fadeOut} />}
      <div className="home-page">
        <Navbar activeTab='home' />
          <div className="container mx-auto section-intro-content justify-center sm:justify-start laptop:max-w-screen-xl desktop:max-w-screen-2xl">
            <div className="inner-container">
              <div className="flex flex-row justify-between -mt-40 sm:-mt-56">
                <div className="intro-left">
                  <div className="intro-section">
                    <motion.div 
                      initial={{ x: 200, opacity: 0 }}
                      whileInView={{ x: 0, opacity: 1 }}
                      transition={{ duration: 1, ease: 'easeInOut'}}
                      className="">
                      <h1 className="first-name text-center text-5xl sm:text-left sm:text-60px">{profile.first_name}</h1>
                      <h2 className="last-name text-center text-7xl sm:text-left sm:text-80px">{profile.last_name}</h2>
                      <h3 className="job-title">{profile.designation}</h3>
                    </motion.div>
                    
                    <div className="intro-buttons">
                      <motion.a 
                      initial={{ y: 200, opacity: 0}}
                      whileInView={{ y: 0, opacity: 1 }}
                      transition={{ duration: 0.3, ease: 'easeInOut' }}
                      whileHover={{ 
                        borderRadius: '0px', // Sharp corners on hover
                        backgroundColor: '#ffffff', // Background color changes to white
                        color: '#000',
                        scale: 1.1, // Scale up slightly
                      }}
                      
                      className="bg-white text-black" href="/resume">Resume
                      </motion.a>

                      <motion.a 
                      initial={{ x: -200, opacity: 0}}
                      whileInView={{ x: 0, opacity: 1 }}
                      transition={{ duration: 0.3, ease: 'easeInOut' }}
                      whileHover={{ 
                        borderRadius: '0px', // Sharp corners on hover
                        backgroundColor: '#ffffff', // Background color changes to white
                        color: '#000',
                        scale: 1.1, // Scale up slightly
                      }}
                      
                      className="bg-white text-black " href="/projects">Projects
                      </motion.a>
                    </div>
                  </div>
                </div>
              </div>
              <div className="social-media-section bottom-20 inset-x-0 sm:inset-x-auto sm:bottom-50px">
                  <SocialLinks profile={profile}/>  
              </div>    
            </div>
          </div>
      </div>
    </>
  );
}
