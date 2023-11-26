
function redirectToIndex(action) {
    if (action === 'add') {
        window.location.href = 'hospital-registration.php'; //button to go to hospital information
    } else if (action === 'export') {
        window.location.href = '../admin-index.php'; 
    }
}
