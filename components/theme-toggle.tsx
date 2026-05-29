"use client";

import { useTheme } from "./theme-provider";
import { HugeiconsIcon } from '@hugeicons/react'
import { Sun, Moon } from '@hugeicons/core-free-icons'

export function ThemeToggle() {
  const { theme, toggleTheme } = useTheme();
  const isDark = theme === "dark";

  return (
    <button
      type="button"
      onClick={toggleTheme}
      className="inline-flex items-center gap-2 text-sm font-medium text-slate-800 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 dark:text-slate-100"
      aria-label={isDark ? "Switch to light mode" : "Switch to dark mode"}
      title={isDark ? "Switch to light mode" : "Switch to dark mode"}
    >
      <span aria-hidden="true">{isDark ? <HugeiconsIcon icon={Moon} /> : <HugeiconsIcon icon={Sun} />}</span>
    </button>
  );
}
