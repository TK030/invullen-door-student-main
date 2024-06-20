function bewijsMeeSturen() {
    const ja = document.getElementById("bewijsja");
    const fileContainer = document.getElementById("fileContainer");

    if (ja.checked) {
        fileContainer.innerHTML = `
            <div class="mb-3">
                <input class="form-control" type="file" id="file" name="bewijs[]" multiple required>
            </div>`;
    } else {
        fileContainer.innerHTML = '';
    }
}

function addExamFields() {
    const examContainer = document.getElementById('examContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-3';
    newRow.innerHTML = `
        <div class="col">
            <label class="form-label required">Naam Examen:</label>
            <div class="input-group select-container">
                <input type="text" class="form-control" name="examenNaam[]" autocomplete="off" required>
            </div>
        </div>
        <div class="col">
            <label class="form-label required">Code Examen:</label>
            <div class="input-group select-container">
                <input type="text" class="form-control" name="examenCode[]" autocomplete="off" required>
                <button type="button" class="btn btn-danger remove-btn" onclick="removeExamFields(this)">×</button>
            </div>
        </div>
    `;
    examContainer.appendChild(newRow);

}

function removeExamFields(button) {
    const row = button.closest('.row');
    row.remove();
}