import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowLeft01Icon } from "@hugeicons/core-free-icons";
import Link from "next/link";
import { LINK_LABELS } from "@/app/constants";

export default function Header({ link, title, description }: { link: string; title: string; description?: string }) {
  return (
    <header className="flex flex-col gap-3">
      <Link href={link} title={`Back to ${title}`} className="ui-nav-link inline-flex items-center gap-1.5">
        <HugeiconsIcon icon={ArrowLeft01Icon} className="h-[14px] w-[14px]" />
        {LINK_LABELS.back}
      </Link>
      <h1 className="ui-page-title">{title}</h1>
      {description ? <p className="ui-page-description">{description}</p> : null}
    </header>
  )
}