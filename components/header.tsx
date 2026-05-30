import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowLeft01Icon } from "@hugeicons/core-free-icons";
import Link from "next/link";
import { LINK_LABELS } from "@/app/constants";

export default function Header({ link, title, description, children }: { link: string; title?: string; description?: string; children?: React.ReactNode }) {
  return (
    <header className="flex flex-col gap-3">
      <div className="flex items-center justify-between gap-3">
        <Link href={link} title={title ? `Back to ${title}` : LINK_LABELS.back} className="ui-nav-link inline-flex items-center gap-1.5">
          <HugeiconsIcon icon={ArrowLeft01Icon} className="h-[14px] w-[14px]" />
          {LINK_LABELS.back}
        </Link>
        {children ? <div className="flex flex-wrap items-center justify-end gap-2">{children}</div> : null}
      </div>
      {title ? <h1 className="ui-page-title">{title}</h1> : null}
      {description ? <p className="ui-page-description">{description}</p> : null}
    </header>
  )
}