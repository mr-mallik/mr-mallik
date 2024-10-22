import React from "react"
import Loader from "@/components/Loader"
import dynamic from "next/dynamic";
import { fetchAPI } from "@/lib/fetchAPI";

const Navbar = dynamic(() => import("@/components/Navbar"), {ssr: false});
const AboutMe = dynamic(() => import("./AboutMe"), {ssr: false});

const title = `Gulger Mallik | About Me | Software Engineer | Full Stack Developer`;
const description = "Learn more about Gulger Mallik, a passionate Software Engineer and Full Stack Developer. Discover his professional journey, skills, and personal interests.";
const keywords = 'Gulger Mallik, About Me, Software Engineer, Full Stack Developer, Web Developer, Professional Journey, Skills, Personal Interests, Python, Java, PHP, Laravel, Django, React JS, Next JS, Tailwind CSS, MySQL, PostgreSQL, MongoDB, Git, Rest API, Machine Learning, AI, HTML, CSS, AJAX, GPT API';

export const metadata = {
  title: title,
  description: description,
  keywords: keywords,
  openGraph: {
    title: title,
    description: description,
    url: `${process.env.BASE_URL}/about`,
    images: [
      {
        url: `${process.env.BASE_URL}/assets/images/about-me.png`,
        width: 800,
        height: 600,
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: title,
    description: description,
    images: [`${process.env.BASE_URL}/assets/images/about-me.png`],
  },
};

const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Gulger Mallik",
    "jobTitle": "Software Engineer and Full Stack Developer",
    "url": `${process.env.BASE_URL}`,
    "image": `${process.env.BASE_URL}/assets/images/profile-image.jpg`,
    "sameAs": [
      "https://www.instagram.com/its_mrmallik",
      "https://twitter.com/its_mrmallik",
      "https://www.linkedin.com/in/mrmallik",
      "https://www.github.com/mr-mallik",
      "https://pure.hud.ac.uk/en/persons/gulger-mallik",
      "https://medium.com/@mrmallik",
      "https://mrmallik.medium.com",
      "https://www.kaggle.com/itsmrmallik"
    ],
    "worksFor": {
      "@type": "Organization",
      "name": "University of Huddersfield",
      "url": "https://pure.hud.ac.uk/en/persons/gulger-mallik"
    },
    "knowsAbout": [
      "Software Engineering",
      "Full Stack Development",
      "Web Development",
      "Cloud Computing",
      "JavaScript",
      "React",
      "Node.js",
      "AWS"
    ],
    "description": description
};

export default async function About() {

    try {
        const {data: profile, error_profile} = await fetchAPI(`${process.env.BASE_URL}/api/profile`);
        const {data: service, error_service} = await fetchAPI(`${process.env.BASE_URL}/api/service`);

        if(error_profile || error_service) {
            throw new Error("An error occurred in fetching data");
        }

        if(!profile || !service) {
            return(<Loader />)
        }

        return (
            <>
            <script
                type="application/ld+json"
                dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
            />
                <div className="about-page h-auto overflow-hidden bg-black text-white bg-right bg-no-repeat laptop:h-screen desktop:h-screen">
                    <Navbar activeTab="about" />
                    <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="flex flex-col">
                            {profile && service &&
                                <AboutMe profile={profile} service={service}/>
                            }
                        </div>
                    </div>
                </div>
            </>
        )
    }
    catch (err) {
        console.error("An error occurred", err);
        throw err;
    }
}