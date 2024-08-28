'use client';
import { useState, useEffect } from 'react';
import { motion } from "framer-motion"

import Navbar from "@/components/Navbar"
import Loader from "@/components/Loader"
import Skills from "@/components/Resume/Skills"
import Education from "@/components/Resume/Education"
import Hobbies from "@/components/Resume/Hobbies"
import Work from "@/components/Resume/Work"
import Certificates from "@/components/Resume/Certificates"

export default function Resume() {
  const[isLoading, setLoading] = useState(true);
  const [resume, setResume] = useState(false);
  const [fadeOut, setFadeOut] = useState(false);

  const fetchResume = async () => {
    try {
        const response = await fetch('/api/resume');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        // console.log(data.skills);
        setResume(data);
    } catch (error) {
        console.error('Fetch profile failed:', error);
    }
    finally {
      setFadeOut(true);
      setTimeout(() => setLoading(false), 300);
    }
  };

  useEffect(() => {
    fetchResume();
  }, [])

  return (
      <>
      {isLoading && <Loader hidden={fadeOut} />}
      <div className="resume">
          <Navbar activeTab="resume" />
          <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
              <div className="grid grid-cols-12">
                  {/* LEFT SIDE */}
                  <div className="col-span-12 laptop:col-span-6 pr-4">
                    {resume && <Skills skills={resume.skills} />}
                    {resume && <Education education={resume.education} />}
                  </div>

                  {/* RIGHT SIDE */}
                  <div className="col-span-12 pl-0 laptop:col-span-6 laptop:pl-8">
                      {resume && <Work work={resume.work} />}
                  </div>
              </div>
              <div className="grid grid-cols-12">
                {/* Certificates */}
                <div className="col-span-12">
                  {resume && <Certificates certificates={resume.certifications} />}
                </div>
                {/* Hobbies */}
                <div className="col-span-12">
                  {resume && <Hobbies hobbies={resume.hobbies} />}
                </div>
              </div>
          </div>
      </div>
      </>
  )
} 