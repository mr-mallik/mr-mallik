"use client";
import { motion } from 'framer-motion';
import * as FaIcons from 'react-icons/fa';

const iconMap = {
    'FaGithub': FaIcons.FaGithub,
    'FaLinkedin': FaIcons.FaLinkedin,
    'FaMediumM': FaIcons.FaMediumM,
    'FaTelegram': FaIcons.FaTelegram,
    'FaInstagram': FaIcons.FaInstagram,
    'FaEnvelope': FaIcons.FaEnvelope
};
  
const DynamicIcon = ({ name, className }) => {
    const IconComponent = iconMap[name];

    if (!IconComponent) {
        return <span>Icon not found</span>;
    }

    return <IconComponent className={className} />;
};

function SocialLinks({profile}) {
    return (
        <div className="social-media-links justify-center sm:justify-start ">
            {profile.social_links && profile.social_links.length && 
                profile.social_links.map((social, index) => {  
                    return(
                    <motion.a 
                    initial={{ x: '100vw', rotate: 360 }} // Start off screen to the right, with a full rotation
                    animate={{ x: 0, rotate: 0 }} // End at original position with no rotation
                    transition={{ duration: 1.5, ease: "easeInOut" }} // Animation settings
                    whileHover={{ rotateY: 360 }} // 3D rotate along the Y-axis on hover
                    target="_blank" href={social.link} key={`social-link-${social.title}`}>
                        <DynamicIcon name={social.icon} className="h-8 w-8" />
                    </motion.a>
                    )
                })
            }
        </div>
    )
}

export default SocialLinks;