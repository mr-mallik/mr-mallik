"use client";

import { useEffect, useRef, useState } from "react";

export default function MobileSectionMenu({
  title,
  children,
}: {
  title?: string;
  children: React.ReactNode;
}) {
  const [open, setOpen] = useState(false);
  const containerRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    if (!open) {
      return;
    }

    const previousOverflow = document.body.style.overflow;
    document.body.style.overflow = "hidden";

    const handlePointerDown = (event: MouseEvent) => {
      if (!containerRef.current?.contains(event.target as Node)) {
        setOpen(false);
      }
    };

    const handleEscape = (event: KeyboardEvent) => {
      if (event.key === "Escape") {
        setOpen(false);
      }
    };

    document.addEventListener("mousedown", handlePointerDown);
    document.addEventListener("keydown", handleEscape);

    return () => {
      document.body.style.overflow = previousOverflow;
      document.removeEventListener("mousedown", handlePointerDown);
      document.removeEventListener("keydown", handleEscape);
    };
  }, [open]);

  return (
    <div ref={containerRef} className="relative lg:hidden">
      <button
        type="button"
        onClick={() => setOpen((value) => !value)}
        className="ui-subtle-button inline-flex items-center gap-2"
        aria-expanded={open}
        aria-label={title ?? "Open section navigation"}
      >
        <span className="flex flex-col gap-1" aria-hidden="true">
          <span className="block h-0.5 w-3.5 rounded-full bg-current" />
          <span className="block h-0.5 w-3.5 rounded-full bg-current" />
          <span className="block h-0.5 w-3.5 rounded-full bg-current" />
        </span>
        <span>{title ?? "On this page"}</span>
      </button>

      {open ? (
        <div className="fixed inset-0 z-40 transition-opacity duration-300 ease-out">
          <div className="absolute inset-0 bg-black/20 transition-opacity duration-300 ease-out" aria-hidden="true" />
          <div className="absolute inset-y-0 left-0 flex w-full justify-start overflow-hidden">
            <div
              className="w-[min(22rem,85vw)] border-r border-[var(--ui-border-soft)] bg-background p-4 shadow-xl transition-transform duration-300 ease-out translate-x-0"
              onClick={(event) => {
                if ((event.target as HTMLElement).closest("a")) {
                  setOpen(false);
                }
              }}
            >
              <div className="mb-4 flex items-center justify-between gap-3">
                <p className="ui-meta-text uppercase tracking-wide">{title ?? "On this page"}</p>
                <button
                  type="button"
                  onClick={() => setOpen(false)}
                  className="ui-subtle-button"
                  aria-label="Close navigation"
                >
                  Close
                </button>
              </div>
              <div className="max-h-[calc(100vh-5rem)] overflow-y-auto pr-1">
                {children}
              </div>
            </div>
          </div>
        </div>
      ) : null}
    </div>
  );
}