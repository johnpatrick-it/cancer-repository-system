document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    let nextButtons = document.querySelectorAll('.nextButton');
    let prevButtons = document.querySelectorAll('.prevButton');

    function showStep(step) {
        const steps = document.querySelectorAll('.form-step');
        steps.forEach((s) => {
            s.style.display = 'none';
        });

        document.getElementById(`step${step}`).style.display = 'block';
        currentStep = step;
    }

    function nextStep() {
        if (validateStep(currentStep)) {
            showStep(currentStep + 1);
        }
    }

    function prevStep() {
        showStep(currentStep - 1);
    }

    function validateStep(step) {
        const inputs = document.querySelectorAll(`#step${step} input[required]`);
        for (const input of inputs) {
            if (!input.value.trim()) {
                alert(`Please fill in all required fields in Step ${step}.`);
                return false;
            }
        }
        return true;
    }


    // Show the first step initially
    showStep(1);

    // Attach click event listener to all buttons with the class 'nextButton'
    nextButtons.forEach(button => {
        button.addEventListener('click', nextStep);
    });

    // Attach click event listener to all buttons with the class 'prevButton'
    prevButtons.forEach(button => {
        button.addEventListener('click', prevStep);
    });
});
