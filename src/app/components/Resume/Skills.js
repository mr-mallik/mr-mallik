import Image from 'next/image';

const heading_arr = {
    'tech': 'Programming Languages',
    'frame': 'Framework and Technologies',
    'db': 'Databases',
    'gen': 'General',
    'soft': 'Soft Skills'
}

function Skills({skills}) {

    return (
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Skills</h1>

                {skills.map(([type, skillsList]) => {
                        if(skillsList.length == 0) return null;
                        
                        var heading = heading_arr[type];
                        return (
                            <div key={heading}>
                                <h5 className="tracking-widest mb-1">{heading}:</h5>
                                <div className="flex flex-row flex-wrap gap-0 justify-start content-center">
                                {skillsList.map(skill => (
                                    <div className="w-20 text-center px-0 py-2 mb-3 mr-3 bg-gray-800 border rounded border-transparent hover:border-color-tertiary" key={skill.id}>
                                        <Image className="w-10 m-auto" alt={skill.title} title={skill.title} src={skill.icon} width={76} height={76} />
                                        <p className="pt-2 text-xs">{skill.title}</p>
                                    </div> 
                                ))}
                                </div>
                            </div>
                        )
                    })
                }
                
            </div>  
        </div>
    )
}

export default Skills;