import './bootstrap';

const GET_GENERICS_SIMILAR_PRODUCTS_URL = '/generics/get-similar-products'
const windowPathName = window.location.origin + window.location.pathname;
const mainWrapper = document.querySelector('.main-wrapper');
const spinner = document.querySelector('.spinner');
const restoreModal = document.querySelector('.single-restore-modal');
const deleteTargetModal = document.querySelector('.delete-target-modal');

window.addEventListener('load', () => {
    setupComponents();
    setupForms();
    setupTables();
});

function setupComponents() {
    // ********** Selectize **********
    // singular Selectize
    $('.selectize-singular').selectize({
        plugins: ["auto_position"],
    });

    // singular Linked Selectize
    $('.selectize-singular--linked').selectize({
        plugins: ["auto_position"],
        onChange(value) {
            window.location = value;
        }
    });

    // multiple Selectize
    $('.selectize-multiple').selectize({
        plugins: ["auto_position"],
    });

    // multiple Selectize taggable
    $('.selectize-multiple--taggable').selectize({
        plugins: ["auto_position"],
        create: function (input, callback) {
            callback({
                value: input,
                text: input
            });
        },
        createOnBlur: true,
    });

    // ********** Modal **********
    // Show modal
    document.querySelectorAll('[data-click-action="show-modal"]').forEach((item) => {
        item.addEventListener('click', (evt) => {
            hideAllActiveModals();
            showModal(document.querySelector(evt.currentTarget.dataset.modalTarget));
        });
    });

    // Hide modal
    document.querySelectorAll('[data-click-action="hide-active-modals"]').forEach((item) => {
        item.addEventListener('click', () => {
            hideAllActiveModals();
        });
    });

    document.querySelectorAll('[data-click-action="delete-target"]').forEach((item) => {
        let input = deleteTargetModal.querySelector('input[name="ids[]"]');

        item.addEventListener('click', (evt) => {
            input.value = evt.currentTarget.dataset.targetId;
            showModal(deleteTargetModal);
        });
    });

    // ********** Sortable columns **********
    $('.sortable-columns').sortable();

    // ********** Aside Toggler **********
    document.querySelector('.aside-toggler').addEventListener('click', () => {
        axios.post('/settings/update/full-width')
            .then(response => {
                mainWrapper.classList.toggle('main-wrapper--expanded');
            });
    });

    // ********** Fullscreen **********
    document.querySelectorAll('[data-click-action="request-fullscreen"]').forEach((fullscreenButton) => {
        const fullscreenTarget = document.querySelector(fullscreenButton.dataset.elementTarget);

        fullscreenButton.addEventListener('click', () => {
            // Exit fullscreen mode
            if (document.fullscreenElement) {
                fullscreenTarget.classList.remove('fullscreen');

                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                // Enter fullscreen mode
            } else {
                if (fullscreenTarget.requestFullscreen) {
                    fullscreenTarget.requestFullscreen();
                } else if (fullscreenTarget.webkitRequestFullscreen) {
                    fullscreenTarget.webkitRequestFullscreen();
                } else if (fullscreenTarget.msRequestFullscreen) {
                    fullscreenTarget.msRequestFullscreen();
                }
            }
        });

        // Toggle fullscreen class on fullsreenchange event
        fullscreenTarget.addEventListener('fullscreenchange', (evt) => {
            if (document.fullscreenElement) {
                evt.target.classList.add('fullscreen');
            } else {
                evt.target.classList.remove('fullscreen');
            }
        });
    });

    // ********** Dropdown **********
    // Dropdown button
    document.querySelectorAll('.dropdown__button').forEach((button) => {
        button.addEventListener('click', (evt) => {
            evt.target.closest('.dropdown').classList.toggle('dropdown--active');
        });
    });

    // Hiding dropdown
    document.addEventListener('click', function (evt) {
        document.querySelectorAll('.dropdown--active').forEach((activeDropdown) => {
            // Check if event target is outside of active dropdown
            if (!activeDropdown.contains(evt.target)) {
                activeDropdown.classList.remove('dropdown--active');
            }
        });
    });
}

function setupForms() {
    // ********** Filter Form **********
    const filterForm = document.querySelector('.filter-form');

    if (filterForm) {
        // Remove unnecessary fields before submit
        filterForm.addEventListener('submit', (evt) => {
            // input
            evt.target.querySelectorAll('input').forEach((input) => {
                if (!input.value) {
                    input.remove();
                }
            });

            // Select
            evt.target.querySelectorAll('.selectize-singular').forEach((select) => {
                if (!select.value) {
                    select.remove();
                }
            });
        });

        // Move to the top active filters
        // Multiple selects
        filterForm.querySelectorAll('div.selectize-multiple--highlight').forEach((select) => {
            const formGroup = select.closest('.form-group');
            filterForm.insertBefore(formGroup, filterForm.firstChild);
        });

        // Single selects
        filterForm.querySelectorAll('div.selectize-singular--highlight').forEach((select) => {
            const formGroup = select.closest('.form-group');
            filterForm.insertBefore(formGroup, filterForm.firstChild);
        });

        // Inputs
        filterForm.querySelectorAll('.input--highlight').forEach((input) => {
            const formGroup = input.closest('.form-group');
            filterForm.insertBefore(formGroup, filterForm.firstChild);
        });
    }

    // ********** Columns Update Forms **********
    // Width trackbar
    document.querySelectorAll('.sortable-columns__width-input').forEach((item) => {
        item.addEventListener('input', (evt) => {
            const sortableItem = evt.target.closest('.sortable-columns__item');
            const widthDiv = sortableItem.querySelector('.sortable-columns__width');
            widthDiv.style.width = evt.target.value + 'px';
        });
    });

    // Form Submit
    document.querySelector('.edit-columns-form')?.addEventListener('submit', (evt) => {
        evt.preventDefault();
        showSpinner();

        const form = evt.target;
        let columns = [];
        let order = 1;

        form.querySelectorAll('.sortable-columns__item').forEach((item) => {
            let column = {};

            column.name = item.dataset.columnName;
            column.order = order++;
            column.width = parseInt(item.querySelector('.sortable-columns__width-input').value);
            column.visible = item.querySelector('.switch').checked ? 1 : 0;

            columns.push(column);
        });

        axios.post(form.action, { columns: columns }, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                window.location.reload();
            })
            .finally(function () {
                hideSpinner();
            });
    });

    // ********** Uniqness of Generics on create/update **********
    if (document.querySelector('.generics-create, .generics-edit')) {
        let manufacturerSelect = document.querySelector('select[name="manufacturer_id"]');
        let mnnSelect = document.querySelector('select[name="mnn_id"]');
        let formSelect = document.querySelector('select[name="form_id"]');
        const similarProductsContainer = document.querySelector('.generics-similar-products');

        let selects = [mnnSelect, manufacturerSelect, formSelect];

        for (let select of selects) {
            select.selectize.on('change', function (value) {
                displaySimilarProducts();
            });
        }

        function displaySimilarProducts() {
            const manufacturerID = manufacturerSelect.value;
            const mnnID = mnnSelect.value;
            const formID = formSelect.value;

            // Return while any required fields is empty
            if (manufacturerID == '' || mnnID == '' || formID == '') {
                similarProductsContainer.innerHTML = '';
                return;
            }

            const data = {
                'manufacturer_id' : manufacturerID,
                'mnn_id' : mnnID,
                'form_id' : formID,
            }

            axios.post(GET_GENERICS_SIMILAR_PRODUCTS_URL, data, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    similarProductsContainer.innerHTML = response.data;
                })
                .finally(function () {
                    hideSpinner();
                });
        }
    }
}

function setupTables() {
    // Limited texts
    document.querySelector('.table')?.addEventListener('click', (evt) => {
        if (evt.target.dataset.onClick == 'toggle-text-limit') {
            evt.target.classList.toggle('td__limited-text');
        }
    });

    // Check all
    document.querySelector('.th__checkbox')?.addEventListener('click', () => {
        let checkboxes = document.querySelectorAll('.td__checkbox');
        let checkedAll = document.querySelector('.td__checkbox:not(:checked)') ? false : true;

        // toggle checkbox statements
        for (let chb of checkboxes) {
            chb.checked = !checkedAll;
        }
    });

    // Restore buttons
    document.querySelectorAll('[data-action="restore"]').forEach((btn) => {
        btn.addEventListener('click', (evt) => {
            // change forms id value
            const id = evt.target.dataset.itemId;
            restoreModal.querySelector('input[name="ids[]"]').value = id;

            showModal(restoreModal);
        });
    });
}

function showModal(modal) {
    modal.classList.add('modal--visible');
}

function hideModal(modal) {
    modal.classList.remove('modal--visible');
}

function hideAllActiveModals() {
    document.querySelectorAll('.modal--visible').forEach((modal) => {
        hideModal(modal);
    });
}

function showSpinner() {
    spinner.classList.add('spinner--visible');
}

function hideSpinner() {
    spinner.classList.remove('spinner--visible');
}
