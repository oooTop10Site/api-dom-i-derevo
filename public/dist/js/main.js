function filterForm(url) {
    let inputs = document.querySelectorAll('#filter-form input');

    for (let i = 0, n = inputs.length; i < n; i++) {
        if (
            (inputs[i].value && (inputs[i].type === 'number' || inputs[i].type === 'text' || inputs[i].type === 'date')) ||
            (inputs[i].checked && inputs[i].type === 'checkbox')
        ) {
            url += (url.includes('?') ? '&' : '?') + inputs[i].name + '=' + inputs[i].value;
        }
    }

    let selects = document.querySelectorAll('#filter-form select');

    for (let i = 0, n = selects.length; i < n; i++) {
        if (selects[i].value) {
            url += (url.includes('?') ? '&' : '?') + selects[i].name + '=' + selects[i].value;
        }
    }

    window.location.href = url;
}

function changePreviewImage(el) {
    let imgBlock = el.closest('.form-group').querySelector('#preview_image');

    const [file] = el.files;
    if (file) {
        imgBlock.src = URL.createObjectURL(file);
    }
}
