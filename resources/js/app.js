import './bootstrap';

const GET_GENERICS_SIMILAR_PRODUCTS_URL = '/generics/get-similar-products';
const GET_KVPP_SIMILAR_PRODUCTS_URL = '/kvpp/get-similar-products';
const GET_PROCESSES_CREATE_FORM_INPUTS_URL = '/processes/get-create-form-stage-inputs';
const GET_PROCESSES_CREATE_FORM_YEAR_INPUTS_URL = '/processes/get-create-form-year-inputs';
const GET_PROCESSES_EDIT_FORM_INPUTS_URL = '/processes/get-edit-form-stage-inputs';

const windowPathName = window.location.origin + window.location.pathname;
const mainWrapper = document.querySelector('.main-wrapper');
const spinner = document.querySelector('.spinner');
const restoreModal = document.querySelector('.single-restore-modal');
const deleteTargetModal = document.querySelector('.delete-target-modal');
var countryCodesSelectize; // used as global to access it locally (used only on processes create)

window.addEventListener('load', () => {
    setupComponents();
    setupForms();
    setupTables();
});

function debounce(callback, timeoutDelay = 500) {
    let timeoutId;

    return (...rest) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => callback.apply(this, rest), timeoutDelay);
    };
}

function setupComponents() {
    // ********** Selectize **********
    // singular Selectize
    $('.selectize-singular:not(.selectize--manually-initializable)').selectize({
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
    $('.selectize-multiple:not(.selectize--manually-initializable)').selectize({
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

    // ********** DateRangePicker **********
    $('.date-range-input').daterangepicker({
        autoUpdateInput: false, // make it nullable
        opens: 'left',
        locale: {
            format: 'DD/MM/YYYY'
        },
    });

    // make it nullable
    $('.date-range-input').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.date-range-input').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
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

    // ********** Collapse **********
    document.querySelectorAll(".collapse__header").forEach((header) => {
        header.addEventListener("click", function () {
            let collapse = this.closest(".collapse");;
            collapse.classList.toggle("collapse--open");
        });
    });

    setupSimditor();
    setupNestedSet();
}

function setupForms() {
    // ********** Main Form **********
    // Show spinner to escape multiple submit button
    document.querySelector('.main-form.create-form, .main-form.edit-form')
        ?.addEventListener('submit', () => {
            showSpinner();
        });

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

    // ********** Uniqness of Generics on create **********
    if (document.querySelector('.generics-create')) {
        const similarProductsContainer = document.querySelector('.generics-similar-products');

        let manufacturerSelect = document.querySelector('select[name="manufacturer_id"]');
        let mnnSelect = document.querySelector('select[name="mnn_id"]');
        let formSelect = document.querySelector('select[name="form_id"]');

        let selects = [mnnSelect, manufacturerSelect, formSelect];

        for (let select of selects) {
            select.selectize.on('change', function (value) {
                displayGenericsSimilarProducts();
            });
        }

        function displayGenericsSimilarProducts() {
            const manufacturerID = manufacturerSelect.value;
            const mnnID = mnnSelect.value;
            const formID = formSelect.value;

            // Return while any required fields is empty
            if (manufacturerID == '' || mnnID == '' || formID == '') {
                similarProductsContainer.innerHTML = '';
                return;
            }

            const data = {
                'manufacturer_id': manufacturerID,
                'mnn_id': mnnID,
                'form_id': formID,
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

    // ********** Uniqness of Generics on create **********
    if (document.querySelector('.kvpp-create')) {
        const similarProductsContainer = document.querySelector('.kvpp-similar-products');

        let mnnSelect = document.querySelector('select[name="mnn_id"]');
        let formSelect = document.querySelector('select[name="form_id"]');
        let countryCodeSelect = document.querySelector('select[name="country_code_id"]');

        let doseInput = document.querySelector('input[name="dose"]');
        let packInput = document.querySelector('input[name="pack"]');

        let selects = [mnnSelect, formSelect, countryCodeSelect];
        let inputs = [doseInput, packInput];

        for (let select of selects) {
            select.selectize.on('change', function (value) {
                displayKvppSimilarProducts();
            });
        }

        for (let input of inputs) {
            input.addEventListener('input', function () {
                debounce(displayKvppSimilarProducts());
            });
        }

        function displayKvppSimilarProducts() {
            const mnnID = mnnSelect.value;
            const formID = formSelect.value;
            const countryCodeID = countryCodeSelect.value;
            const dose = doseInput.value;
            const pack = packInput.value;

            // Return while any required fields is empty
            if (mnnID == '' || formID == '' || countryCodeID == '') {
                similarProductsContainer.innerHTML = '';
                return;
            }

            const data = {
                'mnn_id': mnnID,
                'form_id': formID,
                'country_code_id': countryCodeID,
                'dose': dose,
                'pack': pack,
            }

            axios.post(GET_KVPP_SIMILAR_PRODUCTS_URL, data, {
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

    // ********** Processes create/update form **********
    // Create form statuses select
    if (document.querySelector('.processes-create .statusses-selectize')) {
        $('.statusses-selectize').selectize({
            plugins: ["auto_position"],
            onChange(value) {
                updateCreateProcessesStageInputs(value);
            }
        });
    }

    // Create form country codes select
    if (document.querySelector('.country-codes-selectize')) {
        countryCodesSelectize = $('.country-codes-selectize').selectize({
            plugins: ["auto_position"],
            onChange(values) {
                updateCreateProcessesYearInputs(values);
            }
        });
    }

    // Edit form statuses select
    if (document.querySelector('.processes-edit .statusses-selectize')) {
        $('.statusses-selectize').selectize({
            plugins: ["auto_position"],
            onChange(value) {
                updateEditProcessesStageInputs(value);
            }
        });
    }

    // ********** Excape multiple export action **********
    document.querySelectorAll('.export-form').forEach((form) => {
        form.addEventListener('submit', (evt) => {
            evt.target.querySelector('.button').disabled = true;
        });
    });
}

function updateCreateProcessesStageInputs(status_id) {
    showSpinner();

    const data = {
        'generic_id': document.querySelector('input[name="generic_id"]').value,
        'status_id': status_id,
    }

    axios.post(GET_PROCESSES_CREATE_FORM_INPUTS_URL, data, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            // Replace old inputs with new one`s
            document.querySelector('.processes-create__stage-inputs-container').innerHTML = response.data;
            initializeNewComponents();
            updateCreateProcessesYearInputs(countryCodesSelectize[0].selectize.getValue());
        })
        .finally(function () {
            hideSpinner();
        });
}

function updateCreateProcessesYearInputs(values) {
    showSpinner();

    const data = {
        'country_code_ids': values,
        'status_id': document.querySelector('select[name="status_id"]').value,
    }

    axios.post(GET_PROCESSES_CREATE_FORM_YEAR_INPUTS_URL, data, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            // Replace old inputs with new one`s
            document.querySelector('.processes-create__year-inputs-container').innerHTML = response.data;
        })
        .finally(function () {
            hideSpinner();
        });
}

function updateEditProcessesStageInputs(status_id) {
    showSpinner();

    const data = {
        'process_id': document.querySelector('input[name="id"]').value,
        'status_id': status_id,
    }

    axios.post(GET_PROCESSES_EDIT_FORM_INPUTS_URL, data, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            // Replace old inputs with new one`s
            document.querySelector('.processes-edit__stage-inputs-container').innerHTML = response.data;
            initializeNewComponents();
        })
        .finally(function () {
            hideSpinner();
        });
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

function initializeNewComponents() {
    // singular Selectize
    $('select.selectize-singular:not(.selectized)').selectize({
        plugins: ["auto_position"],
    });

    $('select.selectize-multiple:not(.selectize--manually-initializable):not(.selectized)').selectize({
        plugins: ["auto_position"],
    });
}

function setupSimditor() {
    Simditor.locale = 'ru-RU';

    // Simple WYSIWYGS
    document.querySelectorAll('.simditor-textarea').forEach((textarea) => {
        new Simditor({
            textarea: textarea,
            toolbarFloatOffset: '60px',
            imageButton: 'upload',
            toolbar: ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment'] //image removed
            // cleanPaste: true, //clear all styles after pasting,
        });
    });

    // Imaged WYSIWYGS
    document.querySelectorAll('.simditor-textarea--imaged').forEach((textarea) => {
        new Simditor({
            textarea: textarea,
            toolbarFloatOffset: '60px',
            imageButton: 'upload',
            toolbar: ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment', 'image'],
            upload: {
                url: '/simditor-image/upload',   // image upload url by server
                params: { // additional parameters for request
                    folder: 'posts'
                },
                fileKey: 'image', // input name
                connectionCount: 10,
                leaveConfirm: 'Пожалуйста дождитесь окончания загрузки изображений на сервер! Вы уверены что хотите закрыть страницу?'
            },
            defaultImage: '/img/dashboard/default-image.png', // default image thumb while uploading
        });
    });
}

function setupNestedSet() {
    // Nested Sortable
    $('.nested').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        excludeRoot: true,
        maxLevels: 3,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: false,
        branchClass: 'nested__item--parent',
        leafClass: 'nested__item--leaf',
        collapsedClass: 'nested__item--collapsed',
        expandedClass: 'nested__item--expanded',
        hoveringClass: 'nested__item--hover',
    });

    document.querySelectorAll('.nested__item-toggler').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let item = evt.target.closest('.nested__item');
            item.classList.toggle('nested__item--collapsed');
            item.classList.toggle('nested__item--expanded');
        });
    });

    document.querySelectorAll('.nested__item-destroy-btn').forEach((item) => {
        item.addEventListener('click', (evt) => {
            evt.target.closest('.nested__item').remove();
        });
    });

    let updateNestedBtn = document.querySelector('[data-action="update-nestedset"]');

    if (updateNestedBtn) {
        updateNestedBtn.addEventListener('click', () => {
            let url = updateNestedBtn.dataset.url;
            let model = updateNestedBtn.dataset.model;

            let params = {
                itemsHierarchy: $('.nested').nestedSortable('toHierarchy', { startDepthCount: 0 }),
                itemsArray: $('.nested').nestedSortable('toArray', { startDepthCount: 0 })
            }

            if (model) {
                params.model = model;
            }

            axios.post(url, params, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.status === 200) {
                        window.location.reload();
                    } else {
                        console.log('Request failed with status:', response.status);
                    }
                })
                .catch(error => {
                    console.error('An error occurred:', error);
                });
        });
    }
}
