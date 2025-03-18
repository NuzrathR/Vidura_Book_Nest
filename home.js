function showFilterOptions() {
    var filter_container = document.getElementById('filter-options-container');
    if (filter_container.style.display === 'none') {
        filter_container.style.display = 'flex';
    } else {
        filter_container.style.display = 'none';
    }
}