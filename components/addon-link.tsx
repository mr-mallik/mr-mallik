import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import {
	GithubIcon,
	LinkSquare02Icon,
	News01Icon,
	PlayCircleIcon,
} from "@hugeicons/core-free-icons";

import type { ArticleAddonLink } from "@/services/articles";

const KNOWN_ICONS: Record<string, typeof LinkSquare02Icon> = {
	git: GithubIcon,
	github: GithubIcon,
	repo: GithubIcon,
	repository: GithubIcon,
	source: GithubIcon,
	demo: PlayCircleIcon,
	live: PlayCircleIcon,
	preview: PlayCircleIcon,
	article: News01Icon,
	blog: News01Icon,
	post: News01Icon,
};

export default function AddonLink({ item }: { item: ArticleAddonLink }) {
	const key = item.type?.trim().toLowerCase();
	const knownIcon = key ? KNOWN_ICONS[key] : undefined;
	const label = item.label?.trim() || item.type;

	return (
		<Link
			href={item.url}
			target="_blank"
			rel="noreferrer"
			title={label}
			aria-label={label}
			className="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
		>
			<HugeiconsIcon icon={knownIcon ?? LinkSquare02Icon} />
			{knownIcon ? null : <span className="ui-control-text">{label}</span>}
		</Link>
	);
}
