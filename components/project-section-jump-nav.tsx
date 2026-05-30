"use client";

import { useEffect, useMemo, useState } from "react";

import type { TocItem } from "@/services/articles";

export default function ProjectSectionJumpNav({ items }: { items: TocItem[] }) {
  const [activeId, setActiveId] = useState<string | null>(items[0]?.id ?? null);
  const ids = useMemo(() => items.map((item) => item.id), [items]);

  useEffect(() => {
    if (ids.length === 0) {
      return;
    }

    const elements = ids
      .map((id) => document.getElementById(id))
      .filter((element): element is HTMLElement => Boolean(element));

    if (elements.length === 0) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries
          .filter((entry) => entry.isIntersecting)
          .sort((a, b) => b.intersectionRatio - a.intersectionRatio);

        if (visible[0]?.target?.id) {
          setActiveId(visible[0].target.id);
        }
      },
      {
        rootMargin: "-20% 0px -65% 0px",
        threshold: [0.1, 0.25, 0.5, 0.75],
      },
    );

    elements.forEach((element) => observer.observe(element));
    return () => observer.disconnect();
  }, [ids]);

  if (items.length === 0) {
    return null;
  }

  return (
    <nav aria-label="Project sections">
      <div className="flex flex-wrap gap-2">
        {items.map((item) => {
          const isActive = item.id === activeId;

          return (
            <a
              key={item.id}
              href={`#${item.id}`}
              aria-current={isActive ? "location" : undefined}
              className={`inline-flex max-w-full items-center rounded-full border px-3 py-1.5 text-left text-xs font-medium leading-5 transition-colors [overflow-wrap:anywhere] ${
                isActive
                  ? "border-[var(--ui-text-primary)] text-[var(--ui-text-primary)]"
                  : "border-[var(--ui-border-soft)] text-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)]"
              }`}
            >
              {item.text}
            </a>
          );
        })}
      </div>
    </nav>
  );
}