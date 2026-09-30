"use client";

import { motion } from "motion/react";

const EASE_SPRING = [0.16, 1, 0.3, 1] as const;

export function PageTransition({ children }: { children: React.ReactNode }) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 14 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.45, ease: EASE_SPRING }}
    >
      {children}
    </motion.div>
  );
}
