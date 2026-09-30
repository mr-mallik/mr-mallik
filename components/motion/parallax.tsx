"use client";

import { useRef } from "react";
import { motion, useScroll, useTransform, type HTMLMotionProps } from "motion/react";

type ParallaxProps = HTMLMotionProps<"div"> & {
  children?: React.ReactNode;
  /** Max pixel travel across the scroll range. Positive drifts down while scrolling past. */
  offset?: number;
};

export function Parallax({ children, offset = 40, className, ...rest }: ParallaxProps) {
  const ref = useRef<HTMLDivElement>(null);
  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ["start end", "end start"],
  });
  const y = useTransform(scrollYProgress, [0, 1], [-offset, offset]);

  return (
    <motion.div ref={ref} style={{ y }} className={className} {...rest}>
      {children}
    </motion.div>
  );
}
