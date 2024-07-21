import Image from "next/image";
import Navbar from "./components/Navbar";

import {
  FaGithub,
  FaLinkedin,
  FaMediumM,
  FaTelegram,
  FaInstagram,
} from "react-icons/fa";

export default function Home() {

  return (
    <div className="home-page">
      <Navbar activeTab='home' />
        <div className="container mx-auto section-intro-content justify-center sm:justify-start">
          <div className="inner-container">
            <div className="flex flex-row justify-between -mt-40 sm:-mt-56">
              <div className="intro-left">
                <div className="intro-section">
                  <div className="">
                    <div className="first-name text-center text-5xl sm:text-left sm:text-60px">Gulger</div>
                    <div className="last-name text-center text-7xl sm:text-left sm:text-80px">Mallik</div>
                    <div className="job-title">Software Engineer</div>
                  </div>

                  <div className="intro-buttons">
                    <a href="/resume">Resume</a>
                    <a href="/portfolio">Portfolio</a>
                  </div>
                </div>
              </div>
            </div>

            <div className="social-media-section inset-x-0 sm:inset-x-auto bottom-24 sm:bottom-50px">
              <div className="social-media-links justify-center sm:justify-start ">
                <a target="_blank" href="https://github.com/mr-mallik">
                  <FaGithub className="h-8 w-8" />
                </a>
                <a target="_blank" href="https://www.linkedin.com/in/mrmallik/">
                  <FaLinkedin className="h-8 w-8" />
                </a>
                <a target="_blank" href="https://mrmallik.medium.com/">
                  <FaMediumM className="h-8 w-8" />
                </a>
                <a target="_blank" href="https://t.me/mrmallik">
                  <FaTelegram className="h-8 w-8" />
                </a>
                <a target="_blank" href="https://www.instagram.com/_mrmallik_/">
                  <FaInstagram className="h-8 w-8" />
                </a>
              </div>
            </div>
          </div>
        </div>
    </div>
  );
}
