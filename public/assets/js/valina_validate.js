function showError(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-group error';
    const small = formControl.querySelector('small');
    small.innerText = message;
}
function showSuccess(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-group success';
}
function checkRange(input, min, max) {
    let result = false;
    if (input.value && input.value < min) {
        showError(
        input,
        `${getFieldName(input)} phải lớn hơn hoặc bằng ${min}`
        );
    } else if (input.value && input.value > max) {
        showError(
        input,
        `${getFieldName(input)} phải nhỏ hơn hoặc bằng ${max}`
        );
    } else {
        showSuccess(input);
        result = true;
    }
    return result;
}
function getFieldName(input) {
  return input.getAttribute('data-name').charAt(0).toUpperCase() + input.getAttribute('data-name').slice(1);
}
