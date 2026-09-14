// Eleventy 3 configuration for the flaviotavares static site.
import fs from "fs";

export default function (eleventyConfig) {
     // Static assets are copied verbatim to the output (theme CSS/JS/IMG, uploads).
   eleventyConfig.addPassthroughCopy({ "src/assets": "assets" });
   eleventyConfig.setQuietMode(true);

    // Load the menus data once.
   const menus = JSON.parse(
         fs.readFileSync(new URL("./src/_data/menus.json", import.meta.url), "utf8"),
     );

       // A menu renderer usable as a global Nunjucks *function* from page bodies.
       // Used as {{ navi({ menu:'main-en', ulClass:'nav-menu', container:true }) }},
       // which returns HTML verbatim (no auto-escape, unlike a filter).
       // Reproduces WP wp_nav_menu() output (classes, ids, sub-menu nesting).
        eleventyConfig.addNunjucksGlobal("navi", (opts) => {
         const menuName = opts.menu;
         const ulClass = opts.ulClass || "nav-menu";
         const container = opts.container !== false;
         const span = opts.span === true;
         const menu = menus[menuName] || [];

         // Page language, used to mark the active item(s) in the languages
         // switcher, whose items span both locales (hence opts.lang from the page).
         const LANDING = { en: 7, pt_br: 5 };
         const lang =
              opts.lang ||
               (menuName === "main-en" ? "en" : menuName === "main-pt_br" ? "pt_br" : null);
         const landingId = lang ? LANDING[lang] : null;
         const isMain = menuName === "main-en" || menuName === "main-pt_br";
         const isLanguages = menuName === "languages";

          // Active-state classes reproduce WP wp_nav_menu() output for the rendered
          // pages: the current item (current-menu-item/page_item/page-item-N/
          // current_page_item + aria-current="page"), the section landing page
          // (current-page-ancestor / -parent), and — only when the current page is a
          // grandchild — the in-menu parent carrying the "menu gap" classes. The
          // languages switcher marks the active language via current-page-ancestor.
         const byId = new Map();
         menu.forEach((it) => byId.set(it.id, it));

         let currentItem;
         let menuAncestor;
         if (isMain && opts.current) {
            const found = menu.find((i) => i.title_slug === opts.current);
            if (found) {
               currentItem = found;
                const parent = byId.get(found.parent);
                if (parent && parent.children && parent.children.length > 0) {
                    // Grandchild: the immediate parent reads as the "menu gap" ancestor.
                    menuAncestor = parent;
                    }
                 }
             }

         const liClass = (it, hasChildren) => {
             const c = ["menu-item", "menu-item-type-" + (it.type || "post_type")];
             c.push("menu-item-object-" + (it.type === "custom" ? "custom" : it.object || "page"));
             const isCurrentMenuItem = currentItem && it.id === currentItem.id;
             const isAncestor = menuAncestor && it.id === menuAncestor.id;
             const isTopLanding =
                   (menuName === "main-en" && it.id === 34) ||
                   (menuName === "main-pt_br" && it.id === 65);
             const isLangLanding = isLanguages && landingId != null && it.object_id === landingId;
              if (isCurrentMenuItem) {
                 c.push("current-menu-item", "page_item", "page-item-" + it.object_id, "current_page_item");
                    } else if (isAncestor) {
                 c.push("current-page-ancestor", "current-menu-ancestor", "current-menu-parent", "current-page-parent", "current_page_parent", "current_page_ancestor");
                    } else if (isLangLanding) {
                 c.push("current-page-ancestor");
                    } else if (isTopLanding) {
                     // 1-gap (no intermediate parent): the landing carries the parent
                     // class too. 2-gap (intermediate menu present): only the ancestor.
                     c.push("current-page-ancestor", ...(menuAncestor ? [] : ["current-page-parent"]));
                    }
              // A menu item with children places menu-item-has-children right after
              // the active-state block (before the slug); otherwise after menu-item-{id}.
              if (hasChildren) c.push("menu-item-has-children");
              c.push("slug-" + (it.title_slug || it.title.toLowerCase()));
              c.push("menu-item-" + it.id);
              return c.join(" ");
            };

         function renderItems(list, parentId) {
             return list
                  .filter((it) => it.parent === parentId)
                  .map((it) => {
                    const hasChildren = it.children && it.children.length > 0;
                    const aria = currentItem && it.id === currentItem.id
                         ? ' aria-current="page"'
                         : "";
                    const inner = span ? `<span>${it.title}</span>` : it.title;
                    let html = `<li id="menu-item-${it.id}" class="${liClass(it, hasChildren)}"><a href="${it.href}"${aria}>${inner}</a>`;
                    if (hasChildren) html += `\n<ul class="sub-menu">\n${renderItems(list, it.id)}\n</ul>`;
                    html += "</li>";
                    return html;
                    })
                  .join("\n");
            }
         const ul = `<ul id="menu-${menuName}" class="${ulClass}">\n${renderItems(
            menu, 0,
          )}\n</ul>`;
         return container ? `<div class="menu-${menuName}-container">${ul}</div>` : ul;
          });

      return {
           dir: {
                input: "src",
                output: "_site",
                includes: "_includes",
                layouts: "_includes/layouts",
                data: "_data",
                },
           markdownTemplateEngine: "njk",
         };
};
