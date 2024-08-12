function Certificates({certificates}) {
    return (
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Certificates</h1>
                <div className="mb-2 flex flex-row flex-wrap gap-0 justify-between content-center">
                    {certificates.map((cert, idx) => {
                        return(
                            <div className="flex flex-row flex-wrap content-center w-49 px-0 py-2 mr-1 mb-3 bg-gray-800 border rounded border-transparent hover:border-color-tertiary" key={`certificate_${cert.id}`}>
                                {cert.logo &&
                                    <img className="" alt={cert.title} title={cert.title} src={cert.logo} />
                                }
                                <div className="ml-3 mt-1">
                                <h3 className="text-lg">{cert.title}</h3>
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