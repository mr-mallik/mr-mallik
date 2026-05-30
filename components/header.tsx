import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowLeft01Icon } from "@hugeicons/core-free-icons";
import Link from "next/link";
import { LINK_LABELS } from "@/app/constants";

export default function Header({ link, title, description, children }: { link: string; title?: string; description?: string; children?: React.ReactNode }) {
  return (
    <header className="flex flex-col gap-3">
      <div className="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <Link href={link} title={title ? `Back to ${title}` : LINK_LABELS.back} className="ui-nav-link inline-flex items-center gap-1.5">
          <HugeiconsIcon icon={ArrowLeft01Icon} className="h-[14px] w-[14px]" />
          {LINK_LABELS.back}
        </Link>
        {children ? <div className="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:justify-end">{children}</div> : null}
      </div>
      {title ? <h1 className="ui-page-title">{title}</h1> : null}
      {description ? <p className="ui-page-description">{description}</p> : null}
    </header>
  )
}