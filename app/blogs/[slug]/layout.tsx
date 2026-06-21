import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";

import { getArticleBySlug } from "@/services/articles";
import { getTagColorClass } from "@/lib/tag-colors";
import ArticleTocNav from "@/components/article-toc-nav";
import MobileSectionMenu from "@/components/mobile-section-menu";
import ScrollToTopButton from "@/components/scroll-to-top-button";

type BlogSlugParams = {
	slug: string;
};

export default async function BlogArticleLayout({
	children,
	params,
}: {
	children: React.ReactNode;
	params: Promise<BlogSlugParams> | BlogSlugParams;
}) {
	const resolvedParams = await Promise.resolve(params);
	const article = await getArticleBySlug(resolvedParams.slug);

	if (!article) {
		notFound();
	}

	const toc = article.parsedContent.toc;
	const tags = article.tagsData ?? [];
	const related = article.relatedItems ?? [];

	const addonLinks = article.addonLinks
		?.slice()
		.sort((a, b) => (a.order ?? 0) - (b.order ?? 0)) ?? [];

	const hasSidebar = tags.length > 0 || related.length > 0 || addonLinks.length > 0;

	return (
		<>
			<section className="mx-auto w-full max-w-7xl">
				{/* Mobile TOC trigger — shown above content on small screens */}
				{toc.length > 0 ? (
					<div className="mb-5 lg:hidden">
						<MobileSectionMenu title="On this page">
							<ArticleTocNav items={toc} />
						</MobileSectionMenu>
					</div>
				) : null}

				<div className="grid gap-8 lg:grid-cols-[200px_minmax(0,1fr)_200px] lg:gap-12 xl:grid-cols-[220px_minmax(0,1fr)_220px]">
					{/* ── Left: Table of contents ── */}
					<aside className="hidden lg:block">
						<div className="sticky top-20 space-y-3">
							<p className="ui-meta-text uppercase tracking-widest">On this page</p>
							{toc.length > 0 ? (
								<ArticleTocNav items={toc} />
							) : (
								<p className="ui-meta-text italic">No headings found.</p>
							)}
						</div>
					</aside>

					{/* ── Center: article content ── */}
					<main className="min-w-0">{children}</main>

					{/* ── Right: tags, related, links ── */}
					{hasSidebar ? (
						<aside className="hidden lg:block">
							<div className="sticky top-20 space-y-7">
								{tags.length > 0 ? (
									<div className="space-y-2.5">
										<p className="ui-meta-text uppercase tracking-widest">Tags</p>
										<div className="flex flex-wrap gap-1.5">
											{tags.map((tag) => (
												<Link
													key={tag.slug}
													href={`/blogs?tag=${encodeURIComponent(tag.name)}`}
													className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium transition-opacity hover:opacity-75 ${getTagColorClass(tag.name)}`}
												>
													{tag.name}
												</Link>
											))}
										</div>
									</div>
								) : null}

								{related.length > 0 ? (
									<div className="space-y-2.5">
										<p className="ui-meta-text uppercase tracking-widest">Related</p>
										<div className="space-y-2">
											{related.slice(0, 5).map((item) => {
												const href =
													item.type === "project"
														? `/projects/${item.slug}`
														: `/blogs/${item.slug}`;
												return (
													<Link
														key={item.id}
														href={href}
														className="group flex items-center gap-2 rounded-lg border border-[var(--ui-border-subtle)] p-2 transition-colors hover:border-[var(--ui-border-soft)]"
													>
														<div className="relative h-9 w-12 shrink-0 overflow-hidden rounded bg-[var(--ui-border-subtle)]">
															{item.featuredImage ? (
																<Image
																	src={item.featuredImage}
																	alt={item.featuredImageAlt || item.title}
																	fill
																	sizes="48px"
																	className="object-cover transition-opacity group-hover:opacity-90"
																/>
															) : null}
														</div>
														<p className="ui-control-text line-clamp-2 leading-snug [overflow-wrap:anywhere]">
															{item.title}
														</p>
													</Link>
												);
											})}
										</div>
									</div>
								) : null}

								{addonLinks.length > 0 ? (
									<div className="space-y-2">
										<p className="ui-meta-text uppercase tracking-widest">Links</p>
										<div className="space-y-1.5">
											{addonLinks.map((link) => (
												<a
													key={`${link.type}-${link.url}`}
													href={link.url}
													target="_blank"
													rel="noreferrer"
													className="ui-control-text block truncate underline underline-offset-2 hover:text-[var(--ui-text-primary)]"
												>
													{link.label?.trim() || link.type}
												</a>
											))}
										</div>
									</div>
								) : null}
							</div>
						</aside>
					) : (
						<aside className="hidden lg:block" aria-hidden="true" />
					)}
				</div>

				{/* ── Mobile: tags, related, links below content ── */}
				<div className="mt-10 space-y-4 lg:hidden">
					{tags.length > 0 ? (
						<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
							<p className="ui-meta-text mb-3 uppercase tracking-widest">Tags</p>
							<div className="flex flex-wrap gap-1.5">
								{tags.map((tag) => (
									<Link
										key={tag.slug}
										href={`/blogs?tag=${encodeURIComponent(tag.name)}`}
										className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium transition-opacity hover:opacity-75 ${getTagColorClass(tag.name)}`}
									>
										{tag.name}
									</Link>
								))}
							</div>
						</section>
					) : null}

					{related.length > 0 ? (
						<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
							<p className="ui-meta-text mb-3 uppercase tracking-widest">Related</p>
							<div className="space-y-2">
								{related.slice(0, 5).map((item) => {
									const href =
										item.type === "project"
											? `/projects/${item.slug}`
											: `/blogs/${item.slug}`;
									return (
										<Link
											key={item.id}
											href={href}
											className="group flex items-center gap-2 rounded-lg border border-[var(--ui-border-subtle)] p-2 transition-colors hover:border-[var(--ui-border-soft)]"
										>
											<div className="relative h-9 w-12 shrink-0 overflow-hidden rounded bg-[var(--ui-border-subtle)]">
												{item.featuredImage ? (
													<Image
														src={item.featuredImage}
														alt={item.featuredImageAlt || item.title}
														fill
														sizes="48px"
														className="object-cover transition-opacity group-hover:opacity-90"
													/>
												) : null}
											</div>
											<p className="ui-control-text line-clamp-2 leading-snug [overflow-wrap:anywhere]">
												{item.title}
											</p>
										</Link>
									);
								})}
							</div>
						</section>
					) : null}

					{addonLinks.length > 0 ? (
						<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
							<p className="ui-meta-text mb-3 uppercase tracking-widest">Links</p>
							<div className="space-y-1.5">
								{addonLinks.map((link) => (
									<a
										key={`${link.type}-${link.url}`}
										href={link.url}
										target="_blank"
										rel="noreferrer"
										className="ui-control-text block truncate underline underline-offset-2 hover:text-[var(--ui-text-primary)]"
									>
										{link.label?.trim() || link.type}
									</a>
								))}
							</div>
						</section>
					) : null}
				</div>
			</section>

			{/* Floating scroll-to-top */}
			<ScrollToTopButton />
		</>
	);
}
