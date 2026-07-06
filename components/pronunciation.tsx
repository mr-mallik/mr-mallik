"use client";

import { VolumeHighIcon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import { useState } from "react";

// Phonetic respelling spoken by the synthesiser so "Gulger" comes out as "Gul-jar".
const SPOKEN_NAME = "Gul jar";

export function Pronunciation() {
  const [speaking, setSpeaking] = useState(false);

  const speak = () => {
    if (!("speechSynthesis" in window)) return;
    window.speechSynthesis.cancel();
    const utterance = new SpeechSynthesisUtterance(SPOKEN_NAME);
    utterance.lang = "en-GB";
    const britishVoice = window.speechSynthesis
      .getVoices()
      .find((voice) => voice.lang.replace("_", "-").startsWith("en-GB"));
    if (britishVoice) utterance.voice = britishVoice;
    utterance.onend = () => setSpeaking(false);
    utterance.onerror = () => setSpeaking(false);
    setSpeaking(true);
    window.speechSynthesis.speak(utterance);
  };

  return (
    <button
      type="button"
      onClick={speak}
      aria-label="Hear how Gulger is pronounced"
      className={`mt-2 inline-flex items-center gap-1.5 text-sm transition-colors hover:text-[var(--ui-text-primary)] ${
        speaking ? "text-[var(--ui-accent)]" : "text-[var(--ui-text-muted)]"
      }`}
    >
      <HugeiconsIcon icon={VolumeHighIcon} className="h-4 w-4 shrink-0" aria-hidden="true" />
      <span>&ldquo;Gul-jar&rdquo;</span>
    </button>
  );
}
