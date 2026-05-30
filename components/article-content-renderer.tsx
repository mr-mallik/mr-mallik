import type { ParsedBlock } from "@/services/articles";

function renderBlock(block: ParsedBlock, key: string): React.ReactNode {
  if (block.kind === "paragraph") {
    return (
      <p key={key} className="ui-body-text text-[15px] leading-8 [overflow-wrap:anywhere]">
        {block.text}
      </p>
    );
  }

  if (block.kind === "heading") {
    const className =
      block.level <= 2
        ? "ui-item-title mt-10 text-2xl font-semibold tracking-tight"
        : "ui-item-title mt-8 text-xl font-semibold tracking-tight";

    if (block.level <= 2) {
      return (
        <h2 key={key} id={block.id} className={className}>
          {block.text}
        </h2>
      );
    }

    return (
      <h3 key={key} id={block.id} className={className}>
        {block.text}
      </h3>
    );
  }

  if (block.kind === "blockquote") {
    return (
      <blockquote
        key={key}
        className="border-l-2 border-[var(--ui-border-soft)] pl-4 italic ui-body-text text-[15px] leading-7"
      >
        {block.text}
      </blockquote>
    );
  }

  if (block.kind === "image") {
    return (
      <figure key={key} className="my-8 overflow-hidden rounded-lg border border-[var(--ui-border-soft)]">
        {/* eslint-disable-next-line @next/next/no-img-element */}
        <img
          src={block.src}
          alt={block.alt || "Article image"}
          loading="lazy"
          className="h-auto w-full"
        />
      </figure>
    );
  }

  const ListTag = block.kind === "orderedList" ? "ol" : "ul";
  const listClass =
    block.kind === "orderedList"
      ? "list-decimal"
      : "list-disc";

  return (
    <ListTag key={key} className={`${listClass} space-y-3 pl-6 ui-body-text text-[15px] leading-7`}>
      {block.items.map((itemBlocks, index) => (
        <li key={`${key}-${index}`} className="space-y-2">
          {itemBlocks.map((itemBlock, innerIndex) =>
            renderBlock(itemBlock, `${key}-${index}-${innerIndex}`),
          )}
        </li>
      ))}
    </ListTag>
  );
}

export default function ArticleContentRenderer({ blocks }: { blocks: ParsedBlock[] }) {
  return <div className="space-y-5">{blocks.map((block, index) => renderBlock(block, String(index)))}</div>;
}