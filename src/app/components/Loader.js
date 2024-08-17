// components/Spinner.js
import React from 'react';
import Image from 'next/image';
import logo from  "@/assets/images/logo/mallik_logo@0.5x.png"

const Loader = ({hidden}) => {
  return (
    <div className={`fixed inset-0 bg-black flex justify-center items-center z-50 transition-opacity duration-500 ${hidden ? 'opacity-0 pointer-events-none' : 'opacity-100'}`}>
        <Image src={logo} alt="Logo" className="w-24 h-24 animate-spin" width={24} height={24} />
    </div>
  );
};

export default Loader;
