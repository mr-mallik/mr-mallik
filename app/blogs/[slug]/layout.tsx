import Link from "next/link";
import { notFound } from "next/navigation";
import Image from "next/image";

import { getArticleBySlug } from "@/services/articles";
import ArticleTocNav from "@/components/article-toc-nav";

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
	const publishedDate = article.publishedAt
		? new Date(article.publishedAt).toLocaleDateString("en-GB", {
			day: "numeric",
			month: "short",
			year: "numeric",
		})
		: null;

	return (
		<section className="mx-auto w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-8 lg:px-8">
			<div className="grid gap-8 lg:grid-cols-[220px_minmax(0,1fr)_220px] lg:gap-10">
				<aside className="hidden lg:block">
					<div className="sticky top-20">
						<p className="ui-meta-text mb-3 uppercase tracking-wide">On this page</p>
						{toc.length > 0 ? (
							<ArticleTocNav items={toc} />
						) : (
							<p className="ui-meta-text">No section headings.</p>
						)}
					</div>
				</aside>

				<main className="min-w-0">{children}</main>

				<aside className="hidden lg:block">
					<div className="sticky top-20 space-y-6">
						<div className="space-y-2">
							<p className="ui-meta-text uppercase tracking-wide">Meta</p>
							{publishedDate ? <p className="ui-control-text">Published: {publishedDate}</p> : null}
							{article.readCount ? <p className="ui-control-text">Reads: {article.readCount}</p> : null}
							{article.type ? <p className="ui-control-text">Type: {article.type}</p> : null}
						</div>

						{tags.length > 0 ? (
							<div className="space-y-2">
								<p className="ui-meta-text uppercase tracking-wide">Tags</p>
								<div className="flex flex-wrap gap-2">
									{tags.map((tag) => (
										<Link
											key={tag.slug}
											href={`/blogs?tag=${encodeURIComponent(tag.name)}`}
											className="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium transition-colors hover:opacity-80"
											style={{
												borderColor: tag.color || "var(--ui-border-soft)",
												color: tag.color || "var(--ui-text-muted)",
											}}
										>
											{tag.name}
										</Link>
									))}
								</div>
							</div>
						) : null}

						{related.length > 0 ? (
							<div className="space-y-2">
								<p className="ui-meta-text uppercase tracking-wide">Related</p>
								<div className="space-y-2">
									{related.slice(0, 5).map((item) => {
										const href = item.type === "project" ? `/projects/${item.slug}` : `/blogs/${item.slug}`;

										return (
											<Link
												key={item.id}
												href={href}
												className="flex items-center gap-2 rounded-md border border-[var(--ui-border-soft)] p-2 hover:border-[var(--ui-text-muted)]"
											>
												<div className="relative h-10 w-14 shrink-0 overflow-hidden rounded-sm bg-[var(--ui-border-subtle)]">
													{item.featuredImage ? (
														<Image
															src={item.featuredImage}
															alt={item.featuredImageAlt || item.title}
															fill
															sizes="56px"
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
							</div>
						) : null}

						{article.addonLinks && article.addonLinks.length > 0 ? (
							<div className="space-y-2">
								<p className="ui-meta-text uppercase tracking-wide">Links</p>
								<div className="space-y-1.5">
									{article.addonLinks
										.slice()
										.sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
										.map((link) => (
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
			</div>
		</section>
	);
}
