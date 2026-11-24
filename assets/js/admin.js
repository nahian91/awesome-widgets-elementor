document.addEventListener('DOMContentLoaded', function () {
    const masterToggle = document.querySelector('#awea_toggle_all');
    const checkboxes = document.querySelectorAll('.awea-switch-container input[type="checkbox"]:not(#awea_toggle_all)');

    if (masterToggle) {
        masterToggle.addEventListener('change', function () {
            const isChecked = masterToggle.checked;
            checkboxes.forEach((checkbox) => {
                checkbox.checked = isChecked;
            });
        });

        // Check or uncheck the master toggle based on individual checkbox changes
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
                const anyUnchecked = Array.from(checkboxes).some((cb) => !cb.checked);

                if (allChecked) {
                    masterToggle.checked = true;
                } else if (anyUnchecked) {
                    masterToggle.checked = false;
                }
            });
        });
    }
});
