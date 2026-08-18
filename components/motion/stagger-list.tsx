"use client";

import { motion, type HTMLMotionProps, type Variants } from "motion/react";

const EASE_SPRING = [0.16, 1, 0.3, 1] as const;

type StaggerListProps = HTMLMotionProps<"div"> & {
  children: React.ReactNode;
  /** Seconds between each child's entrance. */
  step?: number;
  amount?: number;
};

const containerVariants = (step: number): Variants => ({
  hidden: {},
  show: {
    transition: {
      staggerChildren: step,
    },
  },
});

export function StaggerList({
  children,
  step = 0.07,
  amount = 0.2,
  className,
  ...rest
}: StaggerListProps) {
  return (
    <motion.div
      initial="hidden"
      whileInView="show"
      viewport={{ once: true, amount }}
      variants={containerVariants(step)}
      className={className}
      {...rest}
    >
      {children}
    </motion.div>
  );
}

export const staggerItemVariants: Variants = {
  hidden: { opacity: 0, y: 18 },
  show: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.5, ease: EASE_SPRING },
  },
};

export function StaggerItem({
  children,
  className,
  ...rest
}: HTMLMotionProps<"div"> & { children: React.ReactNode }) {
  return (
    <motion.div variants={staggerItemVariants} className={className} {...rest}>
      {children}
    </motion.div>
  );
}
