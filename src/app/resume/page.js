import Navbar from "../components/Navbar"

export default function Resume() {
    return (
        <div className='about-page h-screen overflow-hidden bg-black text-white bg-right bg-no-repeat'>
            <Navbar activeTab="about" />
            <div className="container mx-auto h-screen">
                <div className="flex">
                    <div className="flex flex-col gap-20 w-2/4 mt-40">
                        <div>
                            <h1 className="text-4xl font-bold mb-2 uppercase tracking-wider underline underline-offset-8">About</h1>
                            <a href="mailto:gulgermallik@gmail.com">Email Me: gulgermallik@gmail.com</a>
                        </div>
                        <div>
                            <p className='text-xl text-justify'>As an experienced web and software engineer with expertise in PHP, MySQL, HTML, CSS, JavaScript, and React.js, I excel at building innovative solutions that meet the unique needs of my clients. My skills include developing custom CMS systems, e-commerce platforms, online ticketing and teaching modules, and more. I am highly skilled at collaborating with cross-functional teams, managing multiple projects and priorities, delivering work on-time and within budget, and mentoring junior team members. With a commitment to excellence and a focus on creative problem-solving, I am eager to leverage my skills and experience to help drive your organization's success.</p>
                        </div>
                    </div>
                    <div className="">
                        
                    </div>
                </div>
            </div>
        </div>
    )
}