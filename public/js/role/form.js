function checkedAllModule(moduleId, isChecked) {
    const items = document.querySelectorAll(`.permission-${moduleId}`);
    items.forEach(item => {
        item.checked = isChecked;
    });
}

function updateModuleCheckboxState(moduleId) {
    const items = document.querySelectorAll(`.permission-${moduleId}`);
    const total = items.length;
    const counterChecked = Array.from(items).filter(item => item.checked).length;

    const moduleCheckbox = document.getElementById(`permissionAll${moduleId}`);
    if (moduleCheckbox) {
        moduleCheckbox.checked = counterChecked === total;
    }
}

function filterPagesByModule(moduleId, searchTerm) {
    const rows = document.querySelectorAll(`.label-page-module-${moduleId}, .label-sub-page-module-${moduleId}, .permission-row`);
    rows.forEach(row => {
        const etiqueta = row.getAttribute('data-etiqueta') || '';
        if (etiqueta.toLowerCase().includes(searchTerm.toLowerCase().trim())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}