"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import Navbar from "@/components/Navbar";
import Loader from "@/components/Loader";
import * as FaIcons from 'react-icons/fa';
import TrackVisibility from 'react-on-screen';
import { motion } from 'framer-motion';


const iconMap = {
  'FaGithub': FaIcons.FaGithub,
  'FaLinkedin': FaIcons.FaLinkedin,
  'FaMediumM': FaIcons.FaMediumM,
  'FaTelegram': FaIcons.FaTelegram,
  'FaInstagram': FaIcons.FaInstagram,
  'FaEnvelope': FaIcons.FaEnvelope
};

const DynamicIcon = ({ name, className }) => {
  const IconComponent = iconMap[name];

  if (!IconComponent) {
    return <span>Icon not found</span>;
  }

  return <IconComponent className={className} />;
};

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
          <div className="container mx-auto section-intro-content justify-center sm:justify-start tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
            <div className="inner-container">
              <div className="flex flex-row justify-between -mt-40 sm:-mt-56">
                <div className="intro-left">
                  <div className="intro-section">
                    <motion.div 
                      initial={{ x: 200, opacity: 0 }}
                      whileInView={{ x: 0, opacity: 1 }}
                      transition={{ duration: 1.5, ease: 'easeInOut', delay: 2 }}
                      className="">
                      <div className="first-name text-center text-5xl sm:text-left sm:text-60px">{profile.first_name}</div>
                      <div className="last-name text-center text-7xl sm:text-left sm:text-80px">{profile.last_name}</div>
                      <div className="job-title">{profile.designation}</div>
                    </motion.div>
                    
                    <div className="intro-buttons">
                      <motion.a 
                      initial={{ x: -200, opacity: 0}}
                      whileInView={{ x: 0, opacity: 1 }}
                      transition={{ duration: 1.5, ease: 'easeInOut' }}
                      whileHover={{ 
                        borderRadius: '0px', // Sharp corners on hover
                        backgroundColor: '#ffffff', // Background color changes to white
                        color: '#000',
                        scale: 1.1, // Scale up slightly
                      }}
                      
                      className="bg-white text-black laptop:bg-black laptop:text-white" href="/resume">Resume
                      </motion.a>

                      <motion.a 
                      initial={{ x: -200, opacity: 0}}
                      whileInView={{ x: 0, opacity: 1 }}
                      transition={{ duration: 1.5, ease: 'easeInOut', delay: 1 }}
                      whileHover={{ 
                        borderRadius: '0px', // Sharp corners on hover
                        backgroundColor: '#ffffff', // Background color changes to white
                        color: '#000',
                        scale: 1.1, // Scale up slightly
                      }}
                      
                      className="bg-white text-black laptop:bg-black laptop:text-white" href="/portfolio">Projects
                      </motion.a>
                    </div>
                  </div>
                </div>
              </div>

              {profile.social_links && profile.social_links.length && (
                  <div className="social-media-section inset-x-0 z-40 sm:inset-x-auto bottom-20 sm:bottom-50px">
                    <div className="social-media-links justify-center sm:justify-start ">
                      {profile.social_links.map((social, index) => {  
                          return(
                            <motion.a 
                            initial={{ x: '100vw', rotate: 360 }} // Start off screen to the right, with a full rotation
                            animate={{ x: 0, rotate: 0 }} // End at original position with no rotation
                            transition={{ duration: 1.5, ease: "easeInOut" }} // Animation settings
                            whileHover={{ rotateY: 360 }} // 3D rotate along the Y-axis on hover
                            target="_blank" href={social.link} key={`social-link-${social.title}`}>
                              <DynamicIcon name={social.icon} className="h-8 w-8" />
                            </motion.a>
                          )
                      })}
                    </div>
                  </div>
                )
              }
            </div>
          </div>
      </div>
    </>
  );
}
