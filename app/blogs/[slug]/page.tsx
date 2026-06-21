import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { HugeiconsIcon } from "@hugeicons/react";
import { Calendar03Icon, ViewIcon } from "@hugeicons/core-free-icons";

import ArticleContentRenderer from "@/components/article-content-renderer";
import CopyUrlButton from "@/components/copy-url-button";
import ShareArticleButton from "@/components/share-article-button";
import { ROUTES } from "@/app/constants";
import { getArticleBySlug } from "@/services/articles";
import { buildBlogPostingJsonLd, buildBreadcrumbJsonLd, createPageMetadata, sanitizeJsonLd } from "@/app/seo";

type BlogSlugParams = {
	slug: string;
};

export async function generateMetadata({
	params,
}: {
	params: Promise<BlogSlugParams> | BlogSlugParams;
}): Promise<Metadata> {
	const resolvedParams = await Promise.resolve(params);
	const article = await getArticleBySlug(resolvedParams.slug);

	if (!article) {
		return {};
	}

	const description = article.excerpt || "Read this article on my blog.";
	const tags = article.tagsData?.map((tag) => tag.name) ?? article.tagsText ?? [];

	return createPageMetadata({
		title: article.title,
		description,
		path: `/blogs/${article.slug}`,
		image: article.featuredImage,
		imageAlt: article.featuredImageAlt || article.title,
		type: "article",
		publishedTime: article.publishedAt,
		modifiedTime: article.updatedAt,
		keywords: tags,
		section: "Blog",
	});
}

export default async function BlogDetailPage({
	params,
}: {
	params: Promise<BlogSlugParams> | BlogSlugParams;
}) {
	const resolvedParams = await Promise.resolve(params);
	const article = await getArticleBySlug(resolvedParams.slug);

	if (!article) {
		notFound();
	}

	const publishedDate = article.publishedAt
		? new Date(article.publishedAt).toLocaleDateString("en-GB", {
			day: "numeric",
			month: "short",
			year: "numeric",
		})
		: null;

	const addonLinks = article.addonLinks
		?.slice()
		.sort((a, b) => (a.order ?? 0) - (b.order ?? 0)) ?? [];

	return (
		<article className="mx-auto w-full max-w-3xl">
			<script
				type="application/ld+json"
				dangerouslySetInnerHTML={{
					__html: sanitizeJsonLd(
						buildBreadcrumbJsonLd([
							{ name: "Home", path: "/" },
							{ name: "Blogs", path: ROUTES.blogs },
							{ name: article.title, path: `/blogs/${article.slug}` },
						]),
					),
				}}
			/>
			<script
				type="application/ld+json"
				dangerouslySetInnerHTML={{
					__html: sanitizeJsonLd(
						buildBlogPostingJsonLd({
							title: article.title,
							description: article.excerpt || "Read this article on my blog.",
							path: `/blogs/${article.slug}`,
							image: article.featuredImage,
							publishedTime: article.publishedAt,
							modifiedTime: article.updatedAt,
							keywords: article.tagsData?.map((tag) => tag.name) ?? article.tagsText ?? [],
						}),
					),
				}}
			/>

			{/* ── Article header ── */}
			<header className="mb-8 space-y-4">
				<h1 className="text-[clamp(1.625rem,3vw,2.375rem)] font-semibold leading-tight tracking-tight text-[var(--ui-text-primary)]">
					{article.title}
				</h1>

				{article.excerpt ? (
					<p className="text-[var(--ui-text-secondary)] text-base leading-relaxed sm:text-[17px]">
						{article.excerpt}
					</p>
				) : null}

				{/* Meta bar: date + reads on left, actions on right */}
				<div className="flex flex-wrap items-center justify-between gap-x-4 gap-y-2 border-b border-t border-[var(--ui-border-subtle)] py-2.5">
					<div className="flex flex-wrap items-center gap-x-3 gap-y-1">
						{publishedDate ? (
							<span className="ui-meta-text inline-flex items-center gap-1.5">
								<HugeiconsIcon icon={Calendar03Icon} className="h-3.5 w-3.5" aria-hidden="true" />
								{publishedDate}
							</span>
						) : null}
						{article.readCount ? (
							<>
								<span className="ui-meta-text opacity-40">&bull;</span>
								<span className="ui-meta-text inline-flex items-center gap-1.5">
									<HugeiconsIcon icon={ViewIcon} className="h-3.5 w-3.5" aria-hidden="true" />
									{article.readCount.toLocaleString()} reads
								</span>
							</>
						) : null}
					</div>

					<div className="flex flex-wrap items-center gap-2">
						<ShareArticleButton
							path={`/blogs/${article.slug}`}
							title={article.title}
							text={article.excerpt || undefined}
						/>
						<CopyUrlButton path={`/blogs/${article.slug}`} />
						{addonLinks.map((item) => (
							<Link
								key={`${item.type}-${item.url}`}
								href={item.url}
								target="_blank"
								rel="noreferrer"
								className="ui-subtle-button"
							>
								{item.label?.trim() || item.type}
							</Link>
						))}
					</div>
				</div>
			</header>

			{/* ── Featured image ── */}
			{article.featuredImage ? (
				<div className="mb-8 overflow-hidden rounded-xl border border-[var(--ui-border-soft)]">
					<Image
						src={article.featuredImage}
						alt={article.featuredImageAlt || article.title}
						width={1200}
						height={675}
						className="h-auto w-full object-cover"
						priority
					/>
				</div>
			) : null}

			{/* ── Content ── */}
			<ArticleContentRenderer blocks={article.parsedContent.blocks} />
		</article>
	);
}
