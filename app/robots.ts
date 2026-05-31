import type { MetadataRoute } from "next";

import { PROFILE } from "@/app/constants";

export default function robots(): MetadataRoute.Robots {
  return {
    rules: {
      userAgent: "*",
      allow: "/",
    },
    sitemap: `${PROFILE.websiteUrl}/sitemap.xml`,
    host: PROFILE.websiteUrl,
  };
}
