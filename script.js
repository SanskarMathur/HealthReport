const regForm = document.getElementById('healthForm');
const fetchForm = document.getElementById('fetchForm');

const btn = document.getElementById('btn');

regForm.addEventListener('submit', function (event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    fetch('submit_form.php', {
        method: 'POST',
        body: formData
    })
        .then(() => {
            alert("Submitted Succesfully");
            form.reset();
        })
        .catch(error => {
            console.error('Form submission failed:', error);
        });
});


fetchForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const form = event.target;
    const email = form.elements.email.value;

    fetch(`fetch_report.php?email=${email}`)
        .then(response => {
            if (response.ok) {
                return response.blob(); // Get the response as a Blob object
            } else {
                throw new Error('Error retrieving the health report');
            }
        })
        .then(blob => {
            const url = URL.createObjectURL(blob);
            window.open(url); // Open the health report in a new window
        })
        .catch(error => {
            console.error('Error:', error);
        });
});


