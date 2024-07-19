import Image from 'next/image';
import Navbar from "../components/Navbar"

// import image
import profile from "../assets/images/gm-1.jpeg"

function About() {
    return (
        <main className=''>
            <Navbar activeTab="about" />
            <div class="container mx-auto">
                <div className="flex w-6/12">
                    <div className="flex flex-col gap-20">
                        <div>
                            <h1 class="text-3xl font-bold mb-2 uppercase tracking-wider underline underline-offset-8">About</h1>
                            <a href="mailto:gulgermallik@gmail.com">gulgermallik@gmail.com</a>
                        </div>
                        <div>
                            <p>As an experienced web and software engineer with expertise in PHP, MySQL, HTML, CSS, JavaScript, and React.js, I excel at building innovative solutions that meet the unique needs of my clients. My skills include developing custom CMS systems, e-commerce platforms, online ticketing and teaching modules, and more. I am highly skilled at collaborating with cross-functional teams, managing multiple projects and priorities, delivering work on-time and within budget, and mentoring junior team members. With a commitment to excellence and a focus on creative problem-solving, I am eager to leverage my skills and experience to help drive your organization's success.</p>
                        </div>
                    </div>
                    <div className="">
                     <Image src={profile} alt="Me" class="" />
                    </div>
                </div>
            </div>
        </main>
    )
}

export default About;