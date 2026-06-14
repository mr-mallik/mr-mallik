import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowLeft01Icon } from "@hugeicons/core-free-icons";
import Link from "next/link";
import { LINK_LABELS } from "@/app/constants";

export default function Header({
  link,
  title,
  description,
  children,
}: {
  link: string;
  title?: string;
  description?: string;
  children?: React.ReactNode;
}) {
  const backLink = (
    <Link
      href={link}
      title={title ? `Back to ${title}` : LINK_LABELS.back}
      className="ui-back-link inline-flex shrink-0 items-center gap-1.5"
    >
      <HugeiconsIcon icon={ArrowLeft01Icon} className="h-[14px] w-[14px]" />
      {LINK_LABELS.back}
    </Link>
  );

  return (
    <header className="flex flex-col gap-3">
      {children ? (
        <>
          <div className="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
            {backLink}
            <div className="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:justify-end">
              {children}
            </div>
          </div>
          {title ? <h1 className="ui-page-title">{title}</h1> : null}
        </>
      ) : title ? (
        <div className="flex items-baseline justify-between gap-4">
          <h1 className="ui-page-title">{title}</h1>
          {backLink}
        </div>
      ) : (
        backLink
      )}
      {description ? <p className="ui-page-description">{description}</p> : null}
    </header>
  );
}
