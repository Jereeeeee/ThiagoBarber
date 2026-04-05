(() => {
    const root = document.querySelector('[data-auth-root]');
    if (!root) {
        return;
    }

    const panelsContainer = root.querySelector('[data-auth-panels]');
    const tabs = Array.from(root.querySelectorAll('[data-auth-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-auth-panel]'));

    const getPanel = (name) => panels.find((panel) => panel.dataset.authPanel === name);

    const getActivePanel = () => getPanel(root.dataset.activePanel === 'register' ? 'register' : 'login');

    const syncHeight = (panel) => {
        if (!panelsContainer || !panel) {
            return;
        }

        panelsContainer.style.height = `${panel.offsetHeight}px`;
    };

    const activatePanel = (next) => {
        const target = getPanel(next);

        if (!target) {
            return;
        }

        root.dataset.activePanel = next;

        tabs.forEach((tab) => {
            const isSelected = tab.dataset.authTab === next;
            tab.setAttribute('aria-selected', String(isSelected));
        });

        requestAnimationFrame(() => syncHeight(target));
    };

    const initial = root.dataset.activePanel === 'register' ? 'register' : 'login';
    activatePanel(initial);

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.authTab;
            if (!target) {
                return;
            }

            activatePanel(target);
        });
    });

    window.addEventListener('resize', () => {
        syncHeight(getActivePanel());
    });

    if ('ResizeObserver' in window) {
        const observer = new ResizeObserver(() => {
            syncHeight(getActivePanel());
        });

        panels.forEach((panel) => observer.observe(panel));
    }
})();
