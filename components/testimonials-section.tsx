import { PencilEdit02Icon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";

import { EXTERNAL_LINKS, SECTION_TITLES } from "@/app/constants";
import { MotionAnchor, ctaHoverTap } from "@/components/motion/motion-link";
import { Reveal } from "@/components/motion/reveal";
import testimonials from "@/data/testimonials.json";

type Testimonial = (typeof testimonials)[number];

// Each row is repeated so one copy is wider than large screens, then the
// track holds two copies for the seamless -50% marquee loop.
const REPEATS_PER_COPY = 2;

function initials(name: string) {
  return name
    .split(" ")
    .map((part) => part[0])
    .join("")
    .slice(0, 2)
    .toUpperCase();
}

function TestimonialCard({ item, hidden }: { item: Testimonial; hidden: boolean }) {
  return (
    <article
      aria-hidden={hidden || undefined}
      className="mr-5 flex w-[300px] shrink-0 flex-col justify-between gap-6 rounded-2xl border border-[var(--ui-border-subtle)] bg-[var(--ui-bg-elevated)] p-6 sm:w-[380px]"
    >
      <blockquote className="text-[15px] leading-relaxed text-[var(--ui-text-secondary)]">
        &ldquo;{item.quote}&rdquo;
      </blockquote>

      <div className="flex items-center gap-3">
        <div
          className="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[var(--ui-border-soft)] bg-[var(--ui-accent-muted)] text-xs font-bold text-[var(--ui-accent)]"
          aria-hidden="true"
        >
          {initials(item.name)}
        </div>
        <div className="min-w-0">
          <p className="text-base font-semibold text-[var(--ui-text-primary)]">
            {item.linkedin ? (
              <a
                href={item.linkedin}
                target="_blank"
                rel="noreferrer"
                tabIndex={hidden ? -1 : undefined}
                className="transition-colors hover:text-[var(--ui-accent)]"
              >
                {item.name}
              </a>
            ) : (
              item.name
            )}
          </p>
          <p className="text-xs text-[var(--ui-text-muted)]">
            {item.role}, {item.organization}
          </p>
        </div>
      </div>
    </article>
  );
}

function MarqueeRow({
  items,
  reverse = false,
  duration,
}: {
  items: Testimonial[];
  reverse?: boolean;
  duration: string;
}) {
  const copy = Array.from({ length: REPEATS_PER_COPY }, () => items).flat();

  return (
    <div
      className={`ui-marquee py-1 ${reverse ? "ui-marquee-reverse" : ""}`}
      style={{ "--marquee-duration": duration } as React.CSSProperties}
    >
      <div className="ui-marquee-track">
        {[...copy, ...copy].map((item, index) => (
          // Only the first set is exposed to assistive tech; the rest are visual repeats.
          <TestimonialCard key={`${item.name}-${index}`} item={item} hidden={index >= items.length} />
        ))}
      </div>
    </div>
  );
}

export default function TestimonialsSection() {
  const half = Math.ceil(testimonials.length / 2);
  const firstRow = testimonials.slice(0, half);
  const secondRow = testimonials.slice(half);

  return (
    <>
      <Reveal className="ui-container mb-12 flex flex-col items-center text-center">
        <h2 className="ui-section-title text-4xl md:text-5xl">{SECTION_TITLES.testimonials}</h2>
        <p className="mt-4 max-w-2xl text-sm leading-relaxed text-[var(--ui-text-muted)]">
          Worked with me? I&apos;d be grateful for a short professional testimonial and impact
          statement. It helps strengthen my profile as an international talent and, with your
          permission, may be featured here.
        </p>
        <MotionAnchor
          href={EXTERNAL_LINKS.testimonialForm}
          target="_blank"
          rel="noreferrer"
          className="mt-6 flex items-center gap-2 rounded-full border border-[var(--ui-border-soft)] px-6 py-3 text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:border-[var(--ui-accent)] hover:text-[var(--ui-text-primary)]"
          {...ctaHoverTap}
        >
          <HugeiconsIcon icon={PencilEdit02Icon} className="h-4 w-4" aria-hidden="true" />
          Share your experience
        </MotionAnchor>
      </Reveal>

      <Reveal className="flex flex-col gap-5" amount={0.1}>
        <MarqueeRow items={firstRow} duration="70s" />
        {secondRow.length > 0 ? <MarqueeRow items={secondRow} reverse duration="80s" /> : null}
      </Reveal>
    </>
  );
}
