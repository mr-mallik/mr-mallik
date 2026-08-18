"use client";

import { motion, useScroll, useSpring } from "motion/react";

export function ScrollProgressBar() {
  const { scrollYProgress } = useScroll();
  const scaleX = useSpring(scrollYProgress, {
    stiffness: 220,
    damping: 32,
    restDelta: 0.001,
  });

  return (
    <motion.div
      aria-hidden="true"
      className="no-print fixed left-0 top-0 z-50 h-[2px] w-full origin-left"
      style={{ scaleX, backgroundColor: "var(--ui-accent)" }}
    />
  );
}
