export default function ProjectDetailLayout({
	children,
}: {
	children: React.ReactNode;
}) {
	return (
		<section className="w-full ui-container py-4 sm:py-8 lg:py-12">
			{children}
		</section>
	);
}
