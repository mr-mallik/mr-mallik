"use client";
import { useState, useEffect } from 'react';
import Image from 'next/image';
import logo from "../assets/images/logo/mallik_logo@0.5x.png"
import Link from 'next/link';
import { usePathname } from 'next/navigation';
import clsx from 'clsx';


// Icon Set
import { DevicePhoneMobileIcon, Bars3Icon, XMarkIcon } from '@heroicons/react/20/solid';

export default function Navbar({activeTab}) {
    const pathname = usePathname();
    const [isOpen, setIsOpen] = useState(false);
    const [profile, setProfile] = useState();

    const fetchProfile = async () => {
        try {
            const response = await fetch('/api/profile');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            setProfile(data);
        } catch (error) {
            console.error('Fetch profile failed:', error);
        }
    };

    
    useEffect(() => {
        fetchProfile();
    }, [])
    
    const toggleMenu = () => {
        setIsOpen(!isOpen);
    }
    
    const links = [
        {name: 'Home', href: '/'},
        {name: 'About', href: '/about'},
        {name: 'Resume', href: '/resume'},
        {name: 'Projects', href: '/projects'},
        {name: 'Stories', href: '/stories'}
    ];
    
    return(
        <header>
            <div className="flex justify-between items-center py-4 px-6 bg-black sm:bg-transparent">
                <div className="flex items-center">
                    <div className="pr-4">
                        <Image src={logo} alt="Mallik Logo" width={50} height={50} />
                    </div>
                    <div className="pr-8">
                        <span className='brand-name'>MR. MALLIK</span>
                    </div>
                    {/* Desktop Nav */}
                    <div className="nav hidden sm:block">
                        <nav className='space-x-8'>
                        {
                            links.map((link) => {
                                return (
                                    <Link key={link.name} href={link.href}
                                    className={clsx(
                                        {'active': pathname === link.href}
                                    )}>{link.name}
                                    </Link>
                                )
                            })
                        }
                        </nav>
                    </div>
                </div>
                <div className='sm:hidden'>
                    <button className='outline-none' onClick={toggleMenu}>
                        {isOpen ? <XMarkIcon className='h-8 w-8' /> : <Bars3Icon className='h-8 w-8' />}
                    </button>
                </div>
                <div className='items-center space-x-3  hidden sm:flex'>
                    <div className='flex items-center space-x-1'>
                    <DevicePhoneMobileIcon className='h-4 w-4' />
                    <a href={profile ? "tel:"+profile.phone : ''}>{profile ? profile.phone : "+1234567890"}</a>
                    </div>
                </div>
            </div>
            {/* Mobile Nav */}
            {isOpen && (
                <div className="sm:hidden">
                    <nav className='flex flex-col space-y-4 p-9 items-center bg-black min-h-screen text-lg'>
                        {
                            links.map((link) => {
                                return (
                                    <Link key={link.name} href={link.href}
                                    className={clsx(
                                        {'active': pathname === link.href}
                                    )}>{link.name}
                                    </Link>
                                )
                            })
                        }
                    </nav>
                </div>
            )}
        </header>
    )
}