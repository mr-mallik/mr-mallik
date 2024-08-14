function Certificates({certificates}) {
    return (
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Certificates</h1>
                <div className="mb-2 grid grid-cols-4 gap-4 justify-between content-center">
                    {certificates.map((cert, idx) => {
                        return(
                            <div className="flex flex-nowrap justify-center content-center px-2 p-2 bg-gray-800 border rounded border-transparent hover:border-color-tertiary" key={`certificate_${cert.id}`}>
                                {cert.logo &&
                                    <img className="w-16 h-16" alt={cert.title} title={cert.title} src={cert.logo} />
                                }
                                <div className="ml-3 my-1 w-3/4">
                                    <h3 className="text-base">{cert.title}</h3>
                                    <h6 className="text-sm italic mb-2">Issued By: {cert.subtitle}</h6>
                                    <p className="pt-2 text-xs">Date: {cert.end_my}</p>
                                </div>
                            </div>
                        )
                    })}
                </div>
            </div>
        </div>
    )
}

export default Certificates;