"use client";

import { useEffect, useMemo, useState } from "react";

import type { TocItem } from "@/services/articles";

type ArticleTocNavProps = {
  items: TocItem[];
};

export default function ArticleTocNav({ items }: ArticleTocNavProps) {
  const [activeId, setActiveId] = useState<string | null>(items[0]?.id ?? null);

  const ids = useMemo(() => items.map((item) => item.id), [items]);

  useEffect(() => {
    if (ids.length === 0) {
      return;
    }

    const headingElements = ids
      .map((id) => document.getElementById(id))
      .filter((element): element is HTMLElement => Boolean(element));

    if (headingElements.length === 0) {
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
        rootMargin: "-18% 0px -65% 0px",
        threshold: [0.1, 0.25, 0.5, 0.75, 1],
      },
    );

    headingElements.forEach((element) => observer.observe(element));

    return () => observer.disconnect();
  }, [ids]);

  return (
    <nav aria-label="Table of contents">
      <ul className="space-y-2">
        {items.map((item) => {
          const isActive = activeId === item.id;

          return (
            <li key={item.id}>
              <a
                href={`#${item.id}`}
                className={`ui-control-text block truncate transition-colors hover:text-[var(--ui-text-primary)] ${
                  isActive ? "font-semibold text-[var(--ui-text-primary)]" : ""
                }`}
                style={{ paddingLeft: `${(item.level - 1) * 10}px` }}
                aria-current={isActive ? "location" : undefined}
              >
                {item.text}
              </a>
            </li>
          );
        })}
      </ul>
    </nav>
  );
}