import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { HugeiconsIcon } from "@hugeicons/react";
import { Calendar03Icon, ViewIcon } from "@hugeicons/core-free-icons";

import ArticleContentRenderer from "@/components/article-content-renderer";
import { ROUTES } from "@/app/constants";
import { getArticleBySlug } from "@/services/articles";
import Header from "@/components/header";
import CopyUrlButton from "@/components/copy-url-button";

type BlogSlugParams = {
	slug: string;
};

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

	return (
		<article className="mx-auto w-full max-w-3xl space-y-6">
			<Header 
        link={ROUTES.blogs} 
        title={article.title} 
        description={article.excerpt
          ? article.excerpt
          : "Read this article on my blog."}
			>
				<CopyUrlButton path={`/blogs/${article.slug}`} />
				{article.addonLinks
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

			<div className="flex flex-wrap items-center gap-x-3 gap-y-1">
					{publishedDate ? (
						<span className="ui-meta-text inline-flex items-center gap-1.5">
							<HugeiconsIcon icon={Calendar03Icon} className="h-3.5 w-3.5" />
							{publishedDate}
						</span>
					) : null}
					{article.readCount ? (
						<>
							<span className="ui-meta-text opacity-40">&bull;</span>
							<span className="ui-meta-text inline-flex items-center gap-1.5">
								<HugeiconsIcon icon={ViewIcon} className="h-3.5 w-3.5" />
								{article.readCount} reads
							</span>
						</>
					) : null}
				</div>

			{article.featuredImage ? (
				<div className="relative overflow-hidden rounded-xl border border-[var(--ui-border-soft)]">
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

			<ArticleContentRenderer blocks={article.parsedContent.blocks} />
		</article>
	);
}
