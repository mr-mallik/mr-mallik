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
    <main className="home-page">
      <Navbar activeTab='home' />
      <div className="container mx-auto">
        <div className="">
          <div className="intro-left">
            <div className="intro-section">
              <div className="">
                <div className="first-name">Gulger</div>
                <div className="last-name">Mallik</div>
                <div className="job-title">Software Engineer</div>
              </div>

              <div className="intro-buttons">
                <a href="/resume">Resume</a>
                <a href="/portfolio">Portfolio</a>
              </div>
            </div>
          </div>

          <div className="intro-right">
            
          </div>
        </div>

        <div className="social-media-section">
          <div className="social-media-links">
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
    </main>
  );
}
