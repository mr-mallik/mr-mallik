"use client";

import Image from "next/image";
import { QRCodeSVG } from "qrcode.react";
import { useState } from "react";

type FlipAvatarProps = {
  src: string;
  alt: string;
  /** vCard payload encoded in the QR code so phones offer to save the contact on scan. */
  vcard: string;
};

export function FlipAvatar({ src, alt, vcard }: FlipAvatarProps) {
  const [flipped, setFlipped] = useState(false);

  return (
    <button
      type="button"
      onClick={() => setFlipped((value) => !value)}
      aria-pressed={flipped}
      aria-label={flipped ? "Show profile photo" : "Show QR code to save contact"}
      title={flipped ? "Tap to show photo" : "Tap to reveal contact QR code"}
      className="relative h-40 w-40 cursor-pointer perspective-[900px] sm:h-44 sm:w-44"
    >
      <div
        className={`relative h-full w-full transition-transform duration-700 transform-3d ${
          flipped ? "rotate-y-180" : ""
        }`}
      >
        <div className="absolute inset-0 overflow-hidden rounded-full bg-[var(--ui-bg-elevated)] backface-hidden">
          <Image
            src={src}
            alt={alt}
            width={176}
            height={176}
            className="h-full w-full object-cover"
            priority
          />
        </div>
        {/* QR codes need a light background to scan reliably, so the back stays white in dark mode too. */}
        <div className="absolute inset-0 rotate-y-180 rounded-2xl bg-white p-4 shadow-md backface-hidden">
          <QRCodeSVG
            value={vcard}
            level="M"
            bgColor="#ffffff"
            fgColor="#171310"
            className="h-full w-full"
            aria-hidden="true"
          />
        </div>
      </div>
    </button>
  );
}
