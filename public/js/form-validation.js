/**
 * @param {HTMLFormElement} element
 */
export function validateForm(element) {
    const fields = element.querySelectorAll('input')
    const submitButton = element.querySelector('[type="submit"]')

    submitButton.setAttribute('disabled', "true")

    fields.forEach(input => {
        if (input.type === 'email') {
            validateEmail(input)
        } else if (input.type === 'password') {
            validatePassword(input)
        }
    })
}

/**
 * @param {HTMLInputElement} element
 */
export function validateEmail(element) {
    element.addEventListener('keypress', (event) => {
        console.log(event.target.value)
    })
}

/**
 * @param {HTMLInputElement} element
 */
function validatePassword(element) {

}