import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    const errorCard = document.getElementById("errorCard");
    const successCard = document.getElementById("successCard");

    [errorCard, successCard].forEach(card => {
        if (card) {
            // trigger slide down + fade in
            setTimeout(() => {
                card.classList.remove('-translate-y-10', 'opacity-0');
                card.classList.add('translate-y-[155%]', 'opacity-100');
            }, 100); // small delay to ensure transition runs

            // auto hide after 2 seconds
            setTimeout(() => {
                card.classList.remove('translate-y-[155%]', 'opacity-100');
                card.classList.add('-translate-y-10', 'opacity-0');
            }, 2200);
        }
    });

    // Use Event Delegation to catch ALL form submits, even in Modals
    document.addEventListener('submit', function (e) {
        const form = e.target;

        // 1. Double-check we are actually dealing with a form
        if (form.tagName !== 'FORM') return;

        console.log('Submitting form:', form.id || 'No ID');

        // 2. Prevent double submission
        if (form.classList.contains('is-submitting')) {
            e.preventDefault();
            return;
        }

        // 3. Add the flag
        form.classList.add('is-submitting');

        // 4. Find the button. 
        // We look for [type="submit"] OR a button with NO type (which defaults to submit)
        const btn = form.querySelector('button[type="submit"], input[type="submit"], button:not([type]):not([data-modal-close])');

        if (btn) {
            // Give it a tiny delay so the browser actually registers the "Submit" 
            // before the button goes into a disabled state
            setTimeout(() => {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                
                if (btn.tagName === 'INPUT') {
                    btn.value = "Processing...";
                } else {
                    btn.innerText = "Processing...";
                }
            }, 10);
        }
    });
});