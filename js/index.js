const ageField = document.getElementById('ageField');
const roleSelect = document.getElementById('roleSelect');

roleSelect.addEventListener('change', () => {
    if (roleSelect.value === 'teacher') {
        ageField.style.display = 'none'
        ageField.value = '20'
    } else {
        ageField.value = ''
        ageField.style.display = 'block'
    }
})