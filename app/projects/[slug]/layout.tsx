import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";

import { getProjectBySlug } from "@/services/articles";

type ProjectSlugParams = {
	slug: string;
};

export default async function ProjectDetailLayout({
	children,
	params,
}: {
	children: React.ReactNode;
	params: Promise<ProjectSlugParams> | ProjectSlugParams;
}) {
	const resolvedParams = await Promise.resolve(params);
	const project = await getProjectBySlug(resolvedParams.slug);

	if (!project) {
		notFound();
	}

	const tags = project.tagsData ?? [];
	const related = project.relatedItems ?? [];
	const publishedDate = project.publishedAt
		? new Date(project.publishedAt).toLocaleDateString("en-GB", {
			day: "numeric",
			month: "short",
			year: "numeric",
		})
		: null;
	const updatedDate = project.updatedAt
		? new Date(project.updatedAt).toLocaleDateString("en-GB", {
			day: "numeric",
			month: "short",
			year: "numeric",
		})
		: null;

	return (
		<section className="mx-auto w-full max-w-6xl px-4 py-4 sm:px-6 sm:py-8 lg:px-8">
			<div className="grid gap-8 lg:grid-cols-[minmax(0,1fr)_280px] lg:gap-10">
				<main className="min-w-0">{children}</main>

				<aside className="min-w-0">
					<div className="space-y-5 lg:sticky lg:top-20">
						<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
							<p className="ui-meta-text mb-3 uppercase tracking-wide">Project info</p>
							<div className="space-y-3">
								{publishedDate ? (
									<div>
										<p className="ui-meta-text">Published</p>
										<p className="ui-control-text mt-1">{publishedDate}</p>
									</div>
								) : null}
								{updatedDate ? (
									<div>
										<p className="ui-meta-text">Updated</p>
										<p className="ui-control-text mt-1">{updatedDate}</p>
									</div>
								) : null}
								{project.readCount ? (
									<div>
										<p className="ui-meta-text">Reads</p>
										<p className="ui-control-text mt-1">{project.readCount}</p>
									</div>
								) : null}
								{project.type ? (
									<div>
										<p className="ui-meta-text">Type</p>
										<p className="ui-control-text mt-1 capitalize">{project.type}</p>
									</div>
								) : null}
							</div>
						</section>

						{tags.length > 0 ? (
							<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
								<p className="ui-meta-text mb-3 uppercase tracking-wide">Tags</p>
								<div className="flex flex-wrap gap-2">
									{tags.map((tag) => (
										<Link
											key={tag.slug}
											href={`/projects?tag=${encodeURIComponent(tag.name)}`}
											className="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium transition-opacity hover:opacity-80"
											style={{
												borderColor: tag.color || "var(--ui-border-soft)",
												color: tag.color || "var(--ui-text-muted)",
											}}
										>
											{tag.name}
										</Link>
									))}
								</div>
							</section>
						) : null}

						{related.length > 0 ? (
							<section className="rounded-2xl border border-[var(--ui-border-soft)] bg-background p-4">
								<p className="ui-meta-text mb-3 uppercase tracking-wide">Related</p>
								<div className="space-y-2">
									{related.slice(0, 4).map((item) => {
										const href = item.type === "project" ? `/projects/${item.slug}` : `/blogs/${item.slug}`;

										return (
											<Link
												key={item.id}
												href={href}
												className="flex items-center gap-2 rounded-lg border border-[var(--ui-border-subtle)] p-2 hover:border-[var(--ui-text-muted)]"
											>
												<div className="relative h-11 w-14 shrink-0 overflow-hidden rounded-md bg-[var(--ui-border-subtle)]">
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
							</section>
						) : null}
					</div>
				</aside>
			</div>
		</section>
	);
}
