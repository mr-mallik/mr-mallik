"use client";

import * as React from "react";
import { Select as SelectPrimitive } from "@base-ui/react/select";
import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowDown01Icon, Tick02Icon } from "@hugeicons/core-free-icons";

import { cn } from "@/lib/utils";

function Select(props: React.ComponentProps<typeof SelectPrimitive.Root>) {
  return <SelectPrimitive.Root data-slot="select" {...props} />;
}

function SelectGroup(props: React.ComponentProps<typeof SelectPrimitive.Group>) {
  return <SelectPrimitive.Group data-slot="select-group" {...props} />;
}

function SelectValue({
  className,
  ...props
}: React.ComponentProps<typeof SelectPrimitive.Value>) {
  return (
    <SelectPrimitive.Value
      data-slot="select-value"
      className={cn("truncate", className)}
      {...props}
    />
  );
}

function SelectTrigger({
  className,
  children,
  ...props
}: React.ComponentProps<typeof SelectPrimitive.Trigger>) {
  return (
    <SelectPrimitive.Trigger
      data-slot="select-trigger"
      className={cn(
        "flex h-9 w-full items-center justify-between gap-2 rounded-md border border-[var(--ui-border-soft)] bg-transparent px-3 py-2 text-sm text-[var(--ui-text-primary)] outline-none transition-colors",
        "hover:border-[var(--ui-text-muted)] focus-visible:border-[var(--ui-accent)]",
        "data-[disabled]:cursor-not-allowed data-[disabled]:opacity-50",
        className,
      )}
      {...props}
    >
      {children}
      <SelectPrimitive.Icon className="flex shrink-0">
        <HugeiconsIcon
          icon={ArrowDown01Icon}
          className="h-4 w-4 text-[var(--ui-text-muted)]"
          aria-hidden="true"
        />
      </SelectPrimitive.Icon>
    </SelectPrimitive.Trigger>
  );
}

function SelectContent({
  className,
  children,
  sideOffset = 6,
  ...props
}: React.ComponentProps<typeof SelectPrimitive.Popup> & {
  sideOffset?: number;
}) {
  return (
    <SelectPrimitive.Portal>
      <SelectPrimitive.Positioner
        sideOffset={sideOffset}
        alignItemWithTrigger={false}
        className="z-50 select-none"
      >
        <SelectPrimitive.ScrollUpArrow className="flex w-full justify-center py-1 text-xs text-[var(--ui-text-muted)]" />
        <SelectPrimitive.Popup
          data-slot="select-content"
          className={cn(
            "max-h-[var(--available-height)] min-w-[var(--anchor-width)] overflow-y-auto rounded-md border border-[var(--ui-border-soft)] bg-background p-1 text-[var(--ui-text-primary)] shadow-md",
            className,
          )}
          {...props}
        >
          {children}
        </SelectPrimitive.Popup>
        <SelectPrimitive.ScrollDownArrow className="flex w-full justify-center py-1 text-xs text-[var(--ui-text-muted)]" />
      </SelectPrimitive.Positioner>
    </SelectPrimitive.Portal>
  );
}

function SelectLabel({
  className,
  ...props
}: React.ComponentProps<typeof SelectPrimitive.GroupLabel>) {
  return (
    <SelectPrimitive.GroupLabel
      data-slot="select-label"
      className={cn(
        "px-2 py-1.5 text-xs font-medium text-[var(--ui-text-muted)]",
        className,
      )}
      {...props}
    />
  );
}

function SelectItem({
  className,
  children,
  ...props
}: React.ComponentProps<typeof SelectPrimitive.Item>) {
  return (
    <SelectPrimitive.Item
      data-slot="select-item"
      className={cn(
        "relative flex w-full cursor-default items-center gap-2 rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none",
        "data-[highlighted]:bg-[var(--ui-bg-elevated)] data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        className,
      )}
      {...props}
    >
      <SelectPrimitive.ItemText>{children}</SelectPrimitive.ItemText>
      <SelectPrimitive.ItemIndicator className="absolute right-2 flex h-4 w-4 items-center justify-center">
        <HugeiconsIcon
          icon={Tick02Icon}
          className="h-4 w-4 text-[var(--ui-accent)]"
          aria-hidden="true"
        />
      </SelectPrimitive.ItemIndicator>
    </SelectPrimitive.Item>
  );
}

export {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
};
