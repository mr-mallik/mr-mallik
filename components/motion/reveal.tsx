"use client";

import { motion, type HTMLMotionProps } from "motion/react";

type MotionTag = "div" | "li" | "article" | "section" | "span" | "aside" | "footer" | "p";

type Direction = "up" | "down" | "left" | "right" | "none";

const OFFSETS: Record<Direction, { x: number; y: number }> = {
  up: { x: 0, y: 24 },
  down: { x: 0, y: -24 },
  left: { x: 24, y: 0 },
  right: { x: -24, y: 0 },
  none: { x: 0, y: 0 },
};

const EASE_SPRING = [0.16, 1, 0.3, 1] as const;

type RevealProps = Omit<HTMLMotionProps<"div">, "ref"> & {
  children: React.ReactNode;
  /** Element/tag to render as. Defaults to "div". */
  as?: MotionTag;
  /** Position within a list; used to auto-stagger the delay. */
  index?: number;
  /** Explicit delay in seconds; overrides the index-based stagger. */
  delay?: number;
  /** Seconds added per index step when auto-staggering. */
  step?: number;
  direction?: Direction;
  duration?: number;
  /** Replay every time the element re-enters the viewport. */
  repeat?: boolean;
  /** Fraction of the element that must be visible to trigger. */
  amount?: number;
  scale?: boolean;
};

const MOTION_TAGS: Record<MotionTag, React.ElementType> = {
  div: motion.div,
  li: motion.li,
  article: motion.article,
  section: motion.section,
  span: motion.span,
  aside: motion.aside,
  footer: motion.footer,
  p: motion.p,
};

export function Reveal({
  children,
  as = "div",
  index = 0,
  delay,
  step = 0.06,
  direction = "up",
  duration = 0.6,
  repeat = false,
  amount = 0.2,
  scale = false,
  className,
  ...rest
}: RevealProps) {
  const offset = OFFSETS[direction];
  const computedDelay = delay ?? index * step;
  const MotionTag = MOTION_TAGS[as];

  return (
    <MotionTag
      initial={{ opacity: 0, x: offset.x, y: offset.y, scale: scale ? 0.94 : 1 }}
      whileInView={{ opacity: 1, x: 0, y: 0, scale: 1 }}
      viewport={{ once: !repeat, amount }}
      transition={{ duration, delay: computedDelay, ease: EASE_SPRING }}
      className={className}
      {...(rest as Record<string, unknown>)}
    >
      {children}
    </MotionTag>
  );
}
