import * as FaIcons from 'react-icons/fa';

const iconMap = {
  'FaUtensils': FaIcons.FaUtensils,
  'FaPlaneDeparture': FaIcons.FaPlaneDeparture,
  'FaLaptop': FaIcons.FaLaptop,
  'FaShoePrints': FaIcons.FaShoePrints
};

const DynamicIcon = ({ name, className }) => {
  const IconComponent = iconMap[name];

  if (!IconComponent) {
    return <span>Icon not found</span>;
  }

  return <IconComponent className={className} />;
};

function Hobbies({hobbies}) {

    return(
        <div className="flex flex-col gap-10 mt-10 desktop:mt-20">
            <div className="flex flex-col gap-2">
                <h1 className="font-bold mb-6 uppercase tracking-wider underline underline-offset-8 color-tertiary laptop:text-2xl desktop:text-4xl">Hobbies & Interests</h1>
                <div className="mb-2 flex flex-row flex-wrap gap-0 justify-start content-center">
                {hobbies.map((hobby, idx) => {

                    return(
                        <div className="w-28 text-center px-2 py-3 mb-3 mr-3" key={`hobby_${idx}`}>
                            <DynamicIcon name={hobby.logo} className="p-3 w-16 h-16 m-auto rounded-b-full border rounded-full" />
                            <p className="pt-2">{hobby.title}</p>
                        </div> 
                    )
                })}
                {/* <div className="mb-2 flex flex-row flex-wrap gap-0 justify-start content-center">
                    <div className="w-28 text-center px-2 py-3 mb-3 mr-3">
                    <FaUtensils className="p-3 w-16 h-16 m-auto rounded-b-full border rounded-full" />
                    <p className="pt-2">Cocking</p>
                    </div> 
                    <div className="w-28 text-center px-2 py-3 mb-3 mr-3">
                    <FaPlaneDeparture className="p-3 w-16 h-16 m-auto rounded-b-full border rounded-full" />
                    <p className="pt-2">Travel</p>
                    </div>
                    <div className="w-28 text-center px-2 py-3 mb-3 mr-3">
                    <FaLaptop className="p-3 w-16 h-16 m-auto rounded-b-full border rounded-full" />
                    <p className="pt-2">Tech</p>
                    </div>
                </div> */}
                </div>
            </div>  
        </div>
    )
}

export default Hobbies;