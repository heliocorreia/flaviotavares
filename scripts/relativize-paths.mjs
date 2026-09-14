// Relativize root-relative URLs in the *built* Eleventy site so it works when
// served from a subpath (GitHub Pages: https://<user>.github.io/<repo>/).
//
// Post-build rewrite of every generated HTML file; source templates and data
// stay byte-identical to WordPress (DOM parity). Only the emitted URLs change.
//
//    _site/index.html                       depth 0   ->  bare    "assets/…"
//    _site/en/index.html                    depth 1   ->  "../"   + "assets/…"
//    _site/en/gallery/index.html            depth 2   ->  "../../"+ "assets/…"
//    _site/en/gallery/paintings/index.html  depth 3   ->  "../../../"+ "assets/…"
//
// depth = number of path components above the file inside _site.  For each
// root-relative URL the leading "/" is stripped and "../" x depth is prepended;
// at depth 0 the URL stays bare ("assets/…"), which resolves within the served
// subtree (NOT "/assets/…", which would resolve off the host top).
//
// Rewritten — any quoted value that starts with a single "/":
//   "en/…"    "pt_br/…"            navi() menu links
//   "assets/…"                      css/js links, head.js loader, <img>/data-* src
//   inside CSS: url("/assets/…")   (none today, but handled if added)
// Left untouched — absolute "https://…" / "http://…" and protocol-relative
// "//host/…", and already-relative "../…".
//
// Idempotent: a 2nd pass finds no single-leading-slash token (results start with
// ".." or a letter), so it's a no-op.

import { readFileSync, writeFileSync, readdirSync, statSync } from "node:fs";
import { join, relative } from "node:path";

const targetDir = process.argv[2] || "_site";

const depthOf = (relPath) => relPath.split("/").length - 1;

function walk(dir) {
   let out = [];
   for (const name of readdirSync(dir)) {
      const full = join(dir, name);
      if (statSync(full).isDirectory()) out = out.concat(walk(full));
      else if (name.endsWith(".html")) out.push(full);
    }
   return out;
}

// A quoted value that starts with exactly one "/" (not "//", not a scheme).
//   group 1 = the opening quote (single or double)
//   group 2 = the rest of the value (no quotes), excluding the leading "/"
// (?!\/) rejects protocol-relative "//host"; a "scheme://" value starts with a
// letter right after the quote, so it never matches the required single "/".
const RX = /(["'])\/(?!\/)([^"']*)/g;

let files = 0;
let tokens = 0;

for (const full of walk(targetDir)) {
   const depth = depthOf(relative(targetDir, full));
   const prefix = "../".repeat(depth);
   const src = readFileSync(full, "utf8");
   const out = src.replace(RX, (m, q, rest) => {
       // Skip absolute schemes and protocol-relative: after a single "/", the
      // next char must not be another "/". Already handled by (?!\///).
      // Skip values that are not real paths (no content) — harmless, but keep
      // behaviour explicit: bare "/" -> prefix.
       if (rest === "") return q + prefix;
       tokens++;
      return q + prefix + rest;
       });
   if (out !== src) {
    writeFileSync(full, out);
    files++;
      }
}

console.log(
   `relativized ${files} file(s), ${tokens} root-relative token(s), depth 0..3`,
   `(prefix per file = "../" x depth)`
  );
