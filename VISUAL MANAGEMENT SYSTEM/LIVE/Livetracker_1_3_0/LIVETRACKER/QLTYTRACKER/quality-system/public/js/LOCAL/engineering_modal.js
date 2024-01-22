function engineeringModalContent(processOrder, qualityStep) {
    return `
        <fieldset>
            <!-- Engineering modal content here... -->

            <!-- Additional content, checkboxes, etc. -->

            <!-- Submit button -->
            <button type="submit" onclick="submitEngineeringForm()">Submit Engineering Form</button>
        </fieldset>
    `;
}

function submitEngineeringForm() {
    // Add your logic to handle the form submission for the engineering fieldset
    console.log('Engineering form submitted!');
}