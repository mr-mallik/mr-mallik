"use client";

import Image from "next/image";
import { QRCodeSVG } from "qrcode.react";
import { useState } from "react";
import { motion } from "motion/react";

type FlipAvatarProps = {
  src: string;
  alt: string;
  /** vCard payload encoded in the QR code so phones offer to save the contact on scan. */
  vcard: string;
};

export function FlipAvatar({ src, alt, vcard }: FlipAvatarProps) {
  const [flipped, setFlipped] = useState(false);

  return (
    <motion.button
      type="button"
      onClick={() => setFlipped((value) => !value)}
      aria-pressed={flipped}
      aria-label={flipped ? "Show profile photo" : "Show QR code to save contact"}
      title={flipped ? "Tap to show photo" : "Tap to reveal contact QR code"}
      className="relative h-40 w-40 cursor-pointer perspective-[900px] sm:h-44 sm:w-44"
      whileHover={{ scale: 1.03 }}
      whileTap={{ scale: 0.97 }}
    >
      <motion.div
        className="relative h-full w-full transform-3d"
        animate={{ rotateY: flipped ? 180 : 0 }}
        transition={{ type: "spring", stiffness: 260, damping: 26 }}
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
      </motion.div>
    </motion.button>
  );
}
