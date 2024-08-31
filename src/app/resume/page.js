import React from "react"
import Loader from "@/components/Loader"
import dynamic from "next/dynamic";
import { fetchAPI } from "@/lib/fetchAPI";

const Navbar = dynamic(() => import("@/components/Navbar"), {ssr: false});
const Skills = dynamic(() => import("@/components/Resume/Skills"), {ssr: false});
const Education = dynamic(() => import("@/components/Resume/Education"), {ssr: false});
const Hobbies = dynamic(() => import("@/components/Resume/Hobbies"), {ssr: false});
const Work = dynamic(() => import("@/components/Resume/Work"), {ssr: false});
const Certificates = dynamic(() => import("@/components/Resume/Certificates"), {ssr: false});

const title = `${process.env.SEO_TITLE} | Resume | Software Engineer | Full Stack Developer`;
const description = "Explore the resume of Gulger Mallik, a skilled Software Engineer and Full Stack Developer. View his education, experience, skills, and certifications.";
const keywords = 'Gulger Mallik, Software Engineer, Full Stack Developer, Resume, Web Developer, Python, Java, PHP, Laravel, Django, React JS, Next JS, Tailwind CSS, MySQL, PostgreSQL, MongoDB, Git, Rest API, Machine Learning, AI, HTML, CSS, AJAX, GPT API';

export const metadata = {
  title: title,
  description: description,
  keywords: keywords,
  openGraph: {
    title: title,
    description: description,
    url: `${process.env.BASE_URL}`,
    images: [
      {
        url: `${process.env.BASE_URL}/assets/images/seo-image.png`,
        width: 800,
        height: 600,
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: title,
    description: description,
    images: [`${process.env.BASE_URL}/assets/images/seo-image.png`],
  },
};

export default async function Resume() {
  
  try {
    const {data: resume, error} = await fetchAPI("https://mrmallik.com/api/resume");

    if(error) {
      throw new Error(error);
    }

    if (!resume) {
      return <Loader />;
    }

    return (
      <>
        <Navbar activeTab="resume" />
        <div className="resume">
          <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
              <div className="grid grid-cols-12">
                  {/* LEFT SIDE */}
                  <div className="col-span-12 laptop:col-span-6 pr-4">
                    {resume.skills && <Skills skills={resume.skills} />}
                    {resume.education && <Education education={resume.education} />}
                  </div>

                  {/* RIGHT SIDE */}
                  <div className="col-span-12 pl-0 laptop:col-span-6 laptop:pl-8">
                      {resume.work && <Work work={resume.work} />}
                  </div>
              </div>
              <div className="grid grid-cols-12">
                {/* Certificates */}
                <div className="col-span-12">
                  {resume.certifications && <Certificates certificates={resume.certifications} />}
                </div>
                {/* Hobbies */}
                <div className="col-span-12">
                  {resume.hobbies && <Hobbies hobbies={resume.hobbies} />}
                </div>
              </div>
          </div>
        </div>
      </>
    )
  }
  catch (err)  {
    console.error("Rendering error occurred: ", err);
    throw err;
  }
}