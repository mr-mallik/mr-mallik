"use client";

import { motion } from "framer-motion";

function Other({other}) {

    return(
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Honours and achievements</h1>
                <div className="mb-2 grid grid-cols-1 gap-2 laptop:grid-cols-2 laptop:gap-3 justify-between content-center">
                    {other.map((oth, idx) => {
                        return(
                            <div kye={`hna-${idx}`} className="flex flex-nowrap justify-center content-center px-2 p-2 bg-gray-800 border rounded border-transparent hover:border-color-tertiary">
                                <div class="rounded flex flex-col tablet:flex-row overflow-hidden shadow-md bg-gray-900">
                                    <div class="overflow-hidden bg-black  w-full tablet:w-2/5 flex justify-center items-center">
                                        <img alt="certificate" class="w-full desktop:h-32" src={(oth.logo) ? `/assets/other/${oth.logo}` : `/assets/other/trophy.png`} />
                                    </div>
                                    <div className="text-left p-5 w-full tablet:w-3/5">
                                        <h3 className="mt-2 mb-1 text-base tablet:text-lg laptop:text-xl desktop:mb-0 desktop:mt-4">{oth.title}</h3>
                                        <h5 className="mt-0 mb-5 text-sm tablet:text-base italic laptop:text-base desktop:mt-4">{oth.subtitle}</h5>
                                        <p className="text-gray-400 pb-2 text-xs tablet:text-base laptop:text-sm desktop:text-base" dangerouslySetInnerHTML={{ __html: oth.content }} ></p>
                                    </div> 
                                </div>
                            </div>
                        )
                    })}
                </div>
            </div>  
        </div>
    )
}

export default Other;