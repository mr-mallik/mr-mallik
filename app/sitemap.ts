import type { MetadataRoute } from "next";

import { PROFILE, ROUTES } from "@/app/constants";
import { cmsApi } from "@/services/cms";
import type { ArticlesResponse } from "@/app/blogs/types";

type SitemapArticle = ArticlesResponse["data"][number];

async function fetchAllArticles(type: "blog" | "project"): Promise<SitemapArticle[]> {
  const pageSize = 100;
  const collected: SitemapArticle[] = [];
  let page = 1;
  let totalPages = 1;

  while (page <= totalPages) {
    const response = await cmsApi.get<ArticlesResponse>("/articles", {
      query: { type, sort: "latest", page, limit: pageSize },
      next: { revalidate: 3600 },
    } as Parameters<typeof cmsApi.get>[1] & { next?: { revalidate: number } });

    const items = response.data ?? [];
    collected.push(...items);

    totalPages = response.meta?.totalPages ?? (items.length === pageSize ? page + 1 : page);
    page += 1;

    if (items.length === 0) {
      break;
    }
  }

  return collected;
}

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const [blogs, projects] = await Promise.all([
    fetchAllArticles("blog"),
    fetchAllArticles("project"),
  ]);

  const staticPages: MetadataRoute.Sitemap = [
    {
      url: PROFILE.websiteUrl,
      changeFrequency: "weekly",
      priority: 1,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.resume}`,
      changeFrequency: "monthly",
      priority: 0.9,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.projects}`,
      changeFrequency: "weekly",
      priority: 0.9,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.publications}`,
      changeFrequency: "monthly",
      priority: 0.8,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.about}`,
      changeFrequency: "monthly",
      priority: 0.9,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.experience}`,
      changeFrequency: "monthly",
      priority: 0.7,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.contact}`,
      changeFrequency: "yearly",
      priority: 0.6,
    },
    {
      url: `${PROFILE.websiteUrl}${ROUTES.blogs}`,
      changeFrequency: "weekly",
      priority: 0.9,
    },
  ];

  const blogEntries: MetadataRoute.Sitemap = blogs.map((article) => ({
    url: `${PROFILE.websiteUrl}/blogs/${article.slug}`,
    lastModified: article.updatedAt ? new Date(article.updatedAt) : new Date(article.publishedAt),
    changeFrequency: "monthly",
    priority: 0.8,
  }));

  const projectEntries: MetadataRoute.Sitemap = projects.map((project) => ({
    url: `${PROFILE.websiteUrl}/projects/${project.slug}`,
    lastModified: project.updatedAt ? new Date(project.updatedAt) : new Date(project.publishedAt),
    changeFrequency: "monthly",
    priority: 0.8,
  }));

  return [...staticPages, ...blogEntries, ...projectEntries];
}
