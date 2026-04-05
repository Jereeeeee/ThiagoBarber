(() => {
    const navRoots = Array.from(document.querySelectorAll('[data-nav-root]'));

    if (navRoots.length === 0) {
        return;
    }

    const closeMenu = (root, toggle, panel) => {
        root.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        panel.hidden = true;
    };

    const openMenu = (root, toggle, panel) => {
        root.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        panel.hidden = false;
    };

    navRoots.forEach((root) => {
        const toggle = root.querySelector('[data-nav-toggle]');
        const panel = root.querySelector('[data-nav-panel]');

        if (!toggle || !panel) {
            return;
        }

        closeMenu(root, toggle, panel);

        toggle.addEventListener('click', () => {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                closeMenu(root, toggle, panel);
                return;
            }

            openMenu(root, toggle, panel);
        });

        panel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                closeMenu(root, toggle, panel);
            });
        });

        document.addEventListener('click', (event) => {
            if (root.contains(event.target)) {
                return;
            }

            closeMenu(root, toggle, panel);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu(root, toggle, panel);
            }
        });
    });
})();
