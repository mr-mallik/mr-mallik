import { Edu_TAS_Beginner } from "next/font/google";

const itemWidth = [
    'w-10/12',
    'w-9/12'
]

function Education({education}) {
    
    return (
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Education</h1>
                <div className="my-2 clear-both">
                    {education.map((edu, index) => {
                        var classWidth = itemWidth[index];
                            return(
                                <div className={`${classWidth} py-5 pr-5 pl-28 mb-4 mr-3 relative float-right bg-gray-900 rounded border-r-4 border-r-color-tertiary`} key={edu.id}> 
                                    <h3 className="absolute text-gray-500 text-opacity-70 text-6xl font-extrabold -left-20 flex justify-center items-center top-1/2 -translate-y-1/2">{edu.end_year}</h3>
                                    <h6 className="text-2xl mb-3">{edu.title}</h6>
                                    <p className="text-lg pt-4 mb-1">{edu.subtitle}</p>
                                    <p className="text-lg">{edu.content} </p>
                                </div> 
                            )
                        })
                    }
                </div>
            </div>  
        </div>
    )
}

export default Education;