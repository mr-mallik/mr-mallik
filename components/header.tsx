import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowLeft02Icon } from "@hugeicons/core-free-icons";
import Link from "next/link";

export default function Header({ link, title, description }: { link: string; title: string; description?: string }) {
  return (
    <header className="flex flex-col gap-2">
          <Link href={link} title={`Back to ${title}`} className="text-gray-500 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100">
            <HugeiconsIcon icon={ArrowLeft02Icon} />
          </Link>
          <h1 className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-3xl">
            {title}
          </h1>
          {description && (
            <p className="max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400 sm:text-lg">
              {description}
            </p>
          )}
        </header>
  )
}