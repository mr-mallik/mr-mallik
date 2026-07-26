"use client";

import { useState } from "react";
import { HugeiconsIcon } from "@hugeicons/react";
import { Link05Icon } from "@hugeicons/core-free-icons";

type CopyUrlButtonProps = {
  path: string;
  className?: string;
};

export default function CopyUrlButton({ path, className }: CopyUrlButtonProps) {
  const [copied, setCopied] = useState(false);

  const handleCopy = async () => {
    const normalizedPath = path.startsWith("/") ? path : `/${path}`;
    const value = `${window.location.origin}${normalizedPath}`;

    try {
      await navigator.clipboard.writeText(value);
      setCopied(true);
      window.setTimeout(() => setCopied(false), 1500);
    } catch {
      setCopied(false);
    }
  };

  return (
    <button type="button" onClick={handleCopy} className={className ?? "cursor-pointer text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"}>
      {copied ? <span className="text-green-500">Copied URL</span> : <HugeiconsIcon icon={Link05Icon} />}
    </button>
  );
}