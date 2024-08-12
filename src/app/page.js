"use client";

import { useState, useEffect } from "react";
import Navbar from "./components/Navbar";
import Loader from "./components/Loader";

import {
  FaGithub,
  FaLinkedin,
  FaMediumM,
  FaTelegram,
  FaInstagram,
  FaEnvelope,
} from "react-icons/fa";


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
        setTimeout(() => setLoading(false), 500);
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
          <div className="container mx-auto section-intro-content justify-center sm:justify-start max-w-screen-lg laptop:max-w-screen-xl desktop:max-w-screen-2xl">
            <div className="inner-container">
              <div className="flex flex-row justify-between -mt-40 sm:-mt-56">
                <div className="intro-left">
                  <div className="intro-section">
                    <div className="">
                      <div className="first-name text-center text-5xl sm:text-left sm:text-60px">{profile.first_name}</div>
                      <div className="last-name text-center text-7xl sm:text-left sm:text-80px">{profile.last_name}</div>
                      <div className="job-title">{profile.designation}</div>
                    </div>

                    <div className="intro-buttons">
                      <a href="/resume">Resume</a>
                      <a href="/portfolio">Portfolio</a>
                    </div>
                  </div>
                </div>
              </div>

              <div className="social-media-section inset-x-0 sm:inset-x-auto bottom-24 sm:bottom-50px">
                <div className="social-media-links justify-center sm:justify-start ">
                  <a target="_blank" href="https://github.com/mr-mallik">
                    <FaGithub className="h-8 w-8" />
                  </a>
                  <a target="_blank" href="https://www.linkedin.com/in/mrmallik/">
                    <FaLinkedin className="h-8 w-8" />
                  </a>
                  <a target="_blank" href="https://mrmallik.medium.com/">
                    <FaMediumM className="h-8 w-8" />
                  </a>
                  <a target="_blank" href="https://t.me/mrmallik">
                    <FaTelegram className="h-8 w-8" />
                  </a>
                  <a target="_blank" href="https://www.instagram.com/_mrmallik_/">
                    <FaInstagram className="h-8 w-8" />
                  </a>
                  <a target="_blank" href="#">
                    <FaEnvelope className="h-8 w-8" />
                  </a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </>
  );
}
