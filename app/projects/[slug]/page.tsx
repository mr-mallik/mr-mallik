import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Calendar03Icon, RefreshIcon, ViewIcon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";

import { ROUTES } from "@/app/constants";
import AddonLink from "@/components/addon-link";
import ArticleContentRenderer from "@/components/article-content-renderer";
import CopyUrlButton from "@/components/copy-url-button";
import Header from "@/components/header";
import ProjectGallery from "@/components/project-gallery";
import ShareArticleButton from "@/components/share-article-button";
import { getArticleAssets, getProjectBySlug } from "@/services/articles";
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

function formatDate(value?: string | null): string | null {
	if (!value) {
		return null;
	}

	return new Date(value).toLocaleDateString("en-GB", {
		day: "numeric",
		month: "short",
		year: "numeric",
	});
}

export default async function ProjectDetailPage({
	params,
}: {
	params: Promise<ProjectSlugParams> | ProjectSlugParams;
}) {
	const resolvedParams = await Promise.resolve(params);
	const [project, assets] = await Promise.all([
		getProjectBySlug(resolvedParams.slug),
		getArticleAssets(resolvedParams.slug),
	]);

	if (!project) {
		notFound();
	}

	const publishedDate = formatDate(project.publishedAt);
	const updatedDate = formatDate(project.updatedAt);
	const tags = project.tagsData ?? [];
	const related = project.relatedItems ?? [];
	const galleryImages = assets.filter((asset) => (asset.type ?? "image") === "image");

	return (
		<article className="w-full">
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

			<div className="grid gap-8 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:gap-12">
				{/* Left column — fixed (sticky) on desktop */}
				<div className="min-w-0 lg:self-start lg:sticky lg:top-24">
					<div className="flex flex-col gap-5">
						<Header link={ROUTES.projects} />

						<h1 className="ui-page-title order-1">{project.title}</h1>

						{project.excerpt ? (
							<p className="ui-page-description text-justify order-3 lg:order-2">{project.excerpt}</p>
						) : null}

						{project.featuredImage ? (
							<div className="order-2 overflow-hidden rounded-2xl bg-background lg:order-3">
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

						<div className="order-4 flex flex-wrap items-center gap-x-4 gap-y-2">
							{updatedDate ? (
								<span className="ui-meta-text inline-flex items-center gap-1.5">
									<HugeiconsIcon icon={RefreshIcon} className="h-3.5 w-3.5" />
									Updated {updatedDate}
								</span>
							) : null}
							{publishedDate ? (
								<span className="ui-meta-text inline-flex items-center gap-1.5">
									<HugeiconsIcon icon={Calendar03Icon} className="h-3.5 w-3.5" />
									Posted {publishedDate}
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
							<div className="order-6 flex flex-wrap gap-2 lg:order-5">
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

						<div className="order-5 flex flex-wrap items-center gap-2 lg:order-6">
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
									<AddonLink key={`${item.type}-${item.url}`} item={item} />
								))}
						</div>
					</div>
				</div>

				{/* Right column — scrollable */}
				<div className="flex min-w-0 flex-col gap-8">
					{galleryImages.length > 0 ? (
						<section className="order-2 lg:order-1">
							<h2 className="ui-meta-text mb-4 uppercase tracking-wide">Gallery</h2>
							<ProjectGallery assets={galleryImages} projectTitle={project.title} />
						</section>
					) : null}

					{project.parsedContent.blocks.length > 0 ? (
						<section className="order-1 lg:order-2">
							<ArticleContentRenderer blocks={project.parsedContent.blocks} />
						</section>
					) : null}

					{related.length > 0 ? (
						<section className="order-3">
							<h2 className="ui-meta-text mb-4 uppercase tracking-wide">Related</h2>
							<div className="grid gap-3 sm:grid-cols-2">
								{related.slice(0, 4).map((item) => {
									const href = item.type === "project" ? `/projects/${item.slug}` : `/blogs/${item.slug}`;

									return (
										<Link
											key={item.id}
											href={href}
											className="flex items-center gap-3 rounded-xl border border-[var(--ui-border-subtle)] p-2.5 hover:border-[var(--ui-text-muted)]"
										>
											<div className="relative h-12 w-16 shrink-0 overflow-hidden rounded-md bg-[var(--ui-border-subtle)]">
												{item.featuredImage ? (
													<Image
														src={item.featuredImage}
														alt={item.featuredImageAlt || item.title}
														fill
														sizes="64px"
														className="object-cover"
													/>
												) : null}
											</div>
											<p className="ui-control-text line-clamp-2 leading-5 [overflow-wrap:anywhere]">
												{item.title}
											</p>
										</Link>
									);
								})}
							</div>
						</section>
					) : null}
				</div>
			</div>
		</article>
	);
}
