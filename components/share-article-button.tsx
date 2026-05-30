"use client";

import { useState } from "react";

type ShareArticleButtonProps = {
  path: string;
  title: string;
  text?: string;
  className?: string;
};

export default function ShareArticleButton({
  path,
  title,
  text,
  className,
}: ShareArticleButtonProps) {
  const [shared, setShared] = useState(false);

  const handleShare = async () => {
    const normalizedPath = path.startsWith("/") ? path : `/${path}`;
    const url = `${window.location.origin}${normalizedPath}`;

    try {
      if (navigator.share) {
        await navigator.share({ title, text, url });
      } else {
        await navigator.clipboard.writeText(url);
      }

      setShared(true);
      window.setTimeout(() => setShared(false), 1500);
    } catch {
      setShared(false);
    }
  };

  return (
    <button type="button" onClick={handleShare} className={className ?? "ui-subtle-button"}>
      {shared ? "Shared" : "Share"}
    </button>
  );
}