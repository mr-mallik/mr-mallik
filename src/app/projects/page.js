import Loader from "@/components/Loader";
import { fetchAPI } from "@/lib/fetchAPI";
import dynamic from "next/dynamic";

const Navbar = dynamic(() => import("@/components/Navbar"), {ssr: false});
const ProjectBox = dynamic(() => import("./ProjectBox"), {ssr: false});

const title = `Gulger Mallik | Projects | Software Engineer | Full Stack Developer`;
const description = "Explore the projects of Gulger Mallik, a skilled Software Engineer and Full Stack Developer. Discover innovative solutions, advanced systems, and custom software developed for various domains, showcasing expertise in web and software development.";
const keywords = 'Gulger Mallik, Projects, Software Engineer, Full Stack Developer, Personal Portfolio, Crowther Audit Program, Automated Test Management System, Business Management Suite, Dashboard Screen Builder, Booking App, E-commerce Platform, Web Development, Software Development, AI Solutions, Data Visualization, Asset Management';

export const metadata = {
  title: title,
  description: description,
  keywords: keywords,
  openGraph: {
    title: title,
    description: description,
    url: `${process.env.BASE_URL}/projects`,
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

const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Project",
    "url": `${process.env.BASE_URL}`,
    "name": "Gulger Mallik's Projects",
    "image": `${process.env.BASE_URL}/assets/images/seo-image.png`,
    "description": description,
    "owns": {
      "@type": "Person",
      "name": "Gulger Mallik"
    }
}

async function Projects() {

    try {
        const {data: projects, error} = await fetchAPI(`${process.env.BASE_URL}/api/projects`);

        if(error) {
            throw new Error("An error occurred when fetching data for projects");
        }

        if(!projects) {
            return <Loader />
        }

        return (
            <>
                <script
                    type="application/ld+json"
                    dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
                />
                <Navbar activeTab='projects' />
                <div className="projects overflow-hidden bg-black text-white">
                    <div className="container mx-auto px-8 max-w-screen-sm tablet:px-0 tablet:max-w-screen-md laptop:max-w-screen-xl desktop:max-w-screen-2xl">
                        <div className="mt-10 desktop:mt-20">
                            <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Projects</h1>
                        </div>
                        <div className="grid grid-cols-1 tablet:grid-cols-2 gap-2 laptop:grid-cols-4 laptop:gap-4 mb-10 mt-10">
                            {projects && projects.map((project, idx) => {
                                return(
                                    <ProjectBox key={`project-box-${idx}`} project={project} />
                                )
                            })}
                        </div>
                    </div>
                </div>
            </>
        );
    }
    catch (err) {
        console.error("An error occurred while rendering projects");
        throw err;
    }
}

export default Projects;