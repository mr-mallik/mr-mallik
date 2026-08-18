"use client";

import { motion } from "motion/react";
import Link from "next/link";

/** Next `Link` with spring hover/tap affordance for primary CTAs. */
export const MotionLink = motion.create(Link);

/** Plain anchor with the same hover/tap affordance, for external links. */
export const MotionAnchor = motion.a;

export const ctaHoverTap = {
  whileHover: { scale: 1.04 },
  whileTap: { scale: 0.97 },
  transition: { duration: 0.15, ease: [0.16, 1, 0.3, 1] as const },
};
