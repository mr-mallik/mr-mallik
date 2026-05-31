import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Calendar03Icon, ViewIcon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";

import { ROUTES } from "@/app/constants";
import ArticleContentRenderer from "@/components/article-content-renderer";
import CopyUrlButton from "@/components/copy-url-button";
import Header from "@/components/header";
import ProjectSectionJumpNav from "@/components/project-section-jump-nav";
import ShareArticleButton from "@/components/share-article-button";
import MobileSectionMenu from "@/components/mobile-section-menu";
import ArticleTocNav from "@/components/article-toc-nav";
import { getProjectBySlug } from "@/services/articles";
import { buildBreadcrumbJsonLd, buildCreativeWorkJsonLd, createPageMetadata, sanitizeJsonLd } from "@/app/seo";

type ProjectSlugParams = {
	slug: string;
};

export async function generateMetadata({
	params,
}: {
	params: Promise<ProjectSlugParams> | ProjectSlugParams;
}): Promise<Metadata> {
	const resolvedParams = await Promise.resolve(params);
	const project = await getProjectBySlug(resolvedParams.slug);

	if (!project) {
		return {};
	}

	const description = project.excerpt || "Explore this project in detail.";
	const tags = project.tagsData?.map((tag) => tag.name) ?? [];

	return createPageMetadata({
		title: project.title,
		description,
		path: `/projects/${project.slug}`,
		image: project.featuredImage,
		imageAlt: project.featuredImageAlt || project.title,
		type: "article",
		publishedTime: project.publishedAt,
		modifiedTime: project.updatedAt,
		keywords: tags,
		section: "Projects",
	});
}

export default async function ProjectDetailPage({
	params,
}: {
	params: Promise<ProjectSlugParams> | ProjectSlugParams;
}) {
	const resolvedParams = await Promise.resolve(params);
	const project = await getProjectBySlug(resolvedParams.slug);

	if (!project) {
		notFound();
	}

	const publishedDate = project.publishedAt
		? new Date(project.publishedAt).toLocaleDateString("en-GB", {
			day: "numeric",
			month: "short",
			year: "numeric",
		})
		: null;

	const tags = project.tagsData ?? [];
	const toc = project.parsedContent.toc;

	return (
		<article className="space-y-8">
			<script
				type="application/ld+json"
				dangerouslySetInnerHTML={{
					__html: sanitizeJsonLd(
						buildBreadcrumbJsonLd([
							{ name: "Home", path: "/" },
							{ name: "Projects", path: ROUTES.projects },
							{ name: project.title, path: `/projects/${project.slug}` },
						]),
					),
				}}
			/>
			<script
				type="application/ld+json"
				dangerouslySetInnerHTML={{
					__html: sanitizeJsonLd(
						buildCreativeWorkJsonLd({
							title: project.title,
							description: project.excerpt || "Explore this project in detail.",
							path: `/projects/${project.slug}`,
							image: project.featuredImage,
							publishedTime: project.publishedAt,
							modifiedTime: project.updatedAt,
							keywords: tags.map((tag) => tag.name),
						}),
					),
				}}
			/>
			<Header
				link={ROUTES.projects}
				title={project.title}
				description={project.excerpt || "Explore this project in detail."}
			>
				<ShareArticleButton
					path={`/projects/${project.slug}`}
					title={project.title}
					text={project.excerpt || undefined}
				/>
				<CopyUrlButton path={`/projects/${project.slug}`} />
				{project.addonLinks
					?.slice()
					.sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
					.map((item) => (
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
			</Header>

			{toc.length > 0 ? (
				<div className="lg:hidden">
					<MobileSectionMenu title="Project sections">
						<ArticleTocNav items={toc} />
					</MobileSectionMenu>
				</div>
			) : null}

			<section className="overflow-hidden rounded-3xl border border-[var(--ui-border-soft)] bg-[linear-gradient(180deg,color-mix(in_srgb,var(--background)_92%,var(--ui-border-subtle))_0%,var(--background)_100%)]">
				<div className="grid gap-6 p-5 sm:p-7 lg:grid-cols-[minmax(0,1.2fr)_minmax(260px,0.8fr)] lg:items-center">
					<div className="space-y-5 min-w-0">
						<div className="flex flex-wrap items-center gap-x-3 gap-y-2">
							{publishedDate ? (
								<span className="ui-meta-text inline-flex items-center gap-1.5">
									<HugeiconsIcon icon={Calendar03Icon} className="h-3.5 w-3.5" />
									{publishedDate}
								</span>
							) : null}
							{project.readCount ? (
								<span className="ui-meta-text inline-flex items-center gap-1.5">
									<HugeiconsIcon icon={ViewIcon} className="h-3.5 w-3.5" />
									{project.readCount} reads
								</span>
							) : null}
						</div>

						{tags.length > 0 ? (
							<div className="flex flex-wrap gap-2">
								{tags.map((tag) => (
									<Link
										key={tag.slug}
										href={`/projects?tag=${encodeURIComponent(tag.name)}`}
										className="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium transition-opacity hover:opacity-80"
										style={{
											borderColor: tag.color || "var(--ui-border-soft)",
											color: tag.color || "var(--ui-text-muted)",
										}}
									>
										{tag.name}
									</Link>
								))}
							</div>
						) : null}

						{toc.length > 0 ? (
							<div className="hidden rounded-2xl border border-[var(--ui-border-soft)]/80 bg-background/70 p-3 lg:block">
								<ProjectSectionJumpNav items={toc} />
							</div>
						) : null}
					</div>

					{project.featuredImage ? (
						<div className="relative overflow-hidden rounded-2xl border border-[var(--ui-border-soft)] bg-background">
							<Image
								src={project.featuredImage}
								alt={project.featuredImageAlt || project.title}
								width={1200}
								height={720}
								className="h-auto w-full object-cover"
								priority
							/>
						</div>
					) : null}
				</div>
			</section>

			<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-5 sm:p-7">
				<ArticleContentRenderer blocks={project.parsedContent.blocks} />
			</section>
		</article>
	);
}
