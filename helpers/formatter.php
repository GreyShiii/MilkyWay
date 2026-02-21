<?php

/**
 * Escape helper (safe HTML output)
 */
function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/**
 * Auto link URLs (expects already-escaped text)
 */
function linkify(string $escaped): string {
  return preg_replace(
    '/(https?:\/\/[^\s<]+)/',
    '<a href="$1" target="_blank" rel="noopener">$1</a>',
    $escaped
  );
}

/**
 * Inline formatting: **bold** and *italic*
 * Input must be escaped already.
 */
function inline_format(string $escaped): string {
  // **bold**
  $escaped = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $escaped);
  // *italic*
  $escaped = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $escaped);
  return $escaped;
}

/**
 * For general single-line formatting (kept for other pages if you use it).
 * Supports:
 *   ***Heading*** -> H1
 *   **Heading**   -> H2
 *   Otherwise -> paragraph
 */
function format_text($text): string
{
  if (is_array($text)) {
    $text = implode("\n", array_map(fn($v) => is_scalar($v) ? (string)$v : '', $text));
  } elseif (!is_scalar($text) && $text !== null) {
    $text = '';
  }

  $raw = trim((string)$text);
  if ($raw === '') return '';

  // H1: ***Heading***
  if (preg_match('/^\*\*\*(.+?)\*\*\*$/s', $raw, $m)) {
    return '<h1 class="didk-heading-xl">' . e(trim($m[1])) . '</h1>';
  }

  // H2: **Heading**
  if (preg_match('/^\*\*(.+?)\*\*$/s', $raw, $m)) {
    return '<h2 class="didk-heading">' . e(trim($m[1])) . '</h2>';
  }

  $escaped = e($raw);
  $escaped = inline_format($escaped);
  $escaped = linkify($escaped);

  return '<p class="didk-paragraph">' . $escaped . '</p>';
}

/**
 * ✅ IMPORTANT:
 * This is what fixes your layout:
 * - Detects numbered Myth lines and groups the next Fact line UNDER it.
 * - Styles Trivia ("Did you know?") like your sample.
 * - Handles Reference/Sanggunian blocks cleanly.
 *
 * Returns an array of HTML strings (already wrapped).
 */
function format_facts(array $factsRaw): array
{
  $out = [];
  $currentBlock = null; // ['num'=>..., 'label'=>..., 'myth'=>..., 'fact'=>...]

  $flushBlock = function() use (&$out, &$currentBlock) {
    if (!$currentBlock) return;

    $num   = e($currentBlock['num']);
    $label = e($currentBlock['label']); // Myth or Mito
    $myth  = e($currentBlock['myth']);
    $fact  = trim($currentBlock['fact'] ?? '');

    $titleHtml =
      '<div class="didk-block-title">' .
        '<span class="didk-num">' . $num . '.</span> ' .
        '<span class="didk-tag didk-tag--myth">' . $label . ':</span> ' .
        '<span class="didk-title-text">' . $myth . '</span>' .
      '</div>';

    $bodyHtml = '';
    if ($fact !== '') {
      $factEsc = linkify(inline_format(e($fact)));
      $bodyHtml =
        '<div class="didk-block-body">' .
          '<span class="didk-tag didk-tag--fact">' . e($currentBlock['factLabel']) . ':</span> ' .
          '<span class="didk-fact-body">' . $factEsc . '</span>' .
        '</div>';
    }

    $out[] = '<div class="didk-block">' . $titleHtml . $bodyHtml . '</div>';

    $currentBlock = null;
  };

  foreach ($factsRaw as $line) {
    if (!is_scalar($line) && $line !== null) continue;
    $raw = trim((string)$line);
    if ($raw === '') continue;

    // --- Reference headings ---
    if (preg_match('/^\*\*(Reference|Sanggunian)\s*:\s*\*\*$/i', $raw, $m)) {
      $flushBlock();
      $out[] = '<div class="didk-ref-title">' . e($m[1]) . ':</div>';
      continue;
    }

    // --- H1/H2 headings inside facts array ---
    if (preg_match('/^\*\*\*(.+?)\*\*\*$/s', $raw, $m)) {
      $flushBlock();
      $out[] = '<h1 class="didk-heading-xl">' . e(trim($m[1])) . '</h1>';
      continue;
    }
    if (preg_match('/^\*\*(.+?)\*\*$/s', $raw, $m) && !preg_match('/^\*\*\d+\./', $raw)) {
      // avoid stealing "**1. Myth:**" lines
      $flushBlock();
      $out[] = '<h2 class="didk-heading">' . e(trim($m[1])) . '</h2>';
      continue;
    }

    // --- Trivia line: **Did you know?** body...
    if (preg_match('/^\*\*(Did you know\?|Alam mo ba\?)\*\*\s*(.+)$/i', $raw, $m)) {
      $flushBlock();

      $tag  = e(trim($m[1]));
      $body = linkify(inline_format(e(trim($m[2]))));

      $out[] =
        '<p class="didk-trivia">' .
          '<span class="didk-trivia-tag">' . $tag . '</span> ' .
          '<span class="didk-trivia-body">' . $body . '</span>' .
        '</p>';
      continue;
    }

    // --- Numbered Myth/Mito: **1. Myth:** something...
    if (preg_match('/^\*\*(\d+)\.\s*(Myth|Mito)\s*:\s*\*\*\s*(.+)$/i', $raw, $m)) {
      $flushBlock();

      $currentBlock = [
        'num'   => $m[1],
        'label' => $m[2],
        'myth'  => trim($m[3]),
        'fact'  => '',
        'factLabel' => 'Fact', // default, can be Katotohanan
      ];
      continue;
    }

    // --- Fact/Katotohanan line: **Fact:** something...
    if (preg_match('/^\*\*(Fact|Katotohanan)\s*:\s*\*\*\s*(.+)$/i', $raw, $m)) {
      // If we have a current myth block, attach it under it.
      if ($currentBlock) {
        $currentBlock['factLabel'] = $m[1];
        $currentBlock['fact']      = trim($m[2]);
      } else {
        // Fact without a myth: just render as a normal paragraph
        $factEsc = linkify(inline_format(e(trim($m[2]))));
        $out[] =
          '<p class="didk-paragraph">' .
            '<span class="didk-tag didk-tag--fact">' . e($m[1]) . ':</span> ' .
            $factEsc .
          '</p>';
      }
      continue;
    }

    // --- URL line alone ---
    if (preg_match('/^https?:\/\/\S+$/i', $raw)) {
      $flushBlock();
      $u = e($raw);
      $out[] = '<p class="didk-paragraph">' . linkify($u) . '</p>';
      continue;
    }

    // --- Default paragraph ---
    // If a Myth block exists and we meet unrelated text, flush first.
    // (prevents weird mixing)
    $flushBlock();

    $escaped = linkify(inline_format(e($raw)));
    $out[] = '<p class="didk-paragraph">' . $escaped . '</p>';
  }

  // flush last block
  $flushBlock();

  return $out;
}