// components/Spinner.js
import React from 'react';
import Image from 'next/image';
import logo from  "../assets/images/logo/mallik_logo@0.5x.png"

const Loader = () => {
  return (
    <div className="flex justify-center items-center w-screen h-screen fixed top-0 left-0 bg-black z-50">
        <Image src={logo} alt="Logo" className="w-24 h-24 animate-spin"/>
    </div>
  );
};

export default Loader;
