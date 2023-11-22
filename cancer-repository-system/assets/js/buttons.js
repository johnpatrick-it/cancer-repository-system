
function redirectToIndex(action) {
    if (action === 'add') {
        window.location.href = '../index.php'; // Redirect to index.html for "Add Hospital"
    } else if (action === 'export') {
        window.location.href = '../index.php'; // Redirect to index.html for "Export"
    }
}
