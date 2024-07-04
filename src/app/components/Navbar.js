import Image from 'next/image';
import logo from "../assets/images/logo/mallik_logo@0.5x.png"

// Icon Set
import { DevicePhoneMobileIcon } from '@heroicons/react/20/solid';

export default function Navbar({activeTab}) {
    return(
        <header className='flex justify-between items-center py-4 px-6'>
            <div className="flex items-center">
                <div className="pr-4">
                    <Image src={logo} alt="Mallik Logo" width={50} height={50} />
                </div>
                <div className="pr-8">
                    <span className='brand-name'>MR. MALLIK</span>
                </div>
                <div className="nav">
                    <nav className='space-x-8'>
                        <a className={activeTab == 'home' ? 'active' : ''} href="/">Home</a>
                        <a className={activeTab == 'about' ? 'active' : ''} href="/about">About</a>
                        <a className={activeTab == 'resume' ? 'active' : ''} href="/resume">Resume</a>
                        <a className={activeTab == 'portfolio' ? 'active' : ''} href="/portfolio">Portfolio</a>
                        <a className={activeTab == 'blog' ? 'active' : ''} href="/blog">Blog</a>
                    </nav>
                </div>
            </div>

            <div className='flex items-center space-x-3'>
                <div className='flex items-center space-x-1'>
                <DevicePhoneMobileIcon className='h-4 w-4' />
                <a>+44 7767 924720</a>
                </div>

            </div>
        </header>
    )
}