// Function to filter books based on genre
function filterBooks(genre) {
    // Redirect with the genre parameter in the URL
    window.location.href = `books.php?genre=${genre}`;
}

// On page load, check the URL for the genre and search parameters
window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const genre = urlParams.get("genre");
    const author = urlParams.get("author");
    const search = urlParams.get("search");
    const section_heading = document.getElementById("search_heading");

    // If genre or search is found in URL, update the heading
    if (genre) {
        section_heading.innerText = genre;
    } else if (search || author){
        section_heading.innerText = "Search Results";
    } else {
        section_heading.innerText = "Top Recommendations";
    }
};

function filterBooksByAuthor(authorName) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `books.php?author=${encodeURIComponent(authorName)}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const responseHTML = document.createElement('div');
            responseHTML.innerHTML = xhr.responseText;

            // Extracting only the book list container from the response
            const newBookList = responseHTML.querySelector("#book_list_container").innerHTML;

            // Replace the current book list container content
            document.getElementById("book_list_container").innerHTML = newBookList;

            // Changing header
            const section_heading = document.getElementById("search_heading");
            section_heading.innerText = "Search Results";
        } else {
            console.error("Failed to fetch books");
        }
    };

    xhr.send();
}
