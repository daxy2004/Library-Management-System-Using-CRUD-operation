class Library {
    constructor() {
        this.books = [];
    }

    addBook(title, author, publisher, year, edition, quantity, genre) {
        const book = {
            id: this.generateId(),
            title,
            author,
            publisher,
            year,
            edition,
            quantity,
            genre
        };
        this.books.push(book);
        return book;
    }

    editBook(id, updatedBook) {
        const bookIndex = this.books.findIndex(book => book.id === parseInt(id));
        if (bookIndex !== -1) {
            this.books[bookIndex] = { ...this.books[bookIndex], ...updatedBook };
            return this.books[bookIndex];
        }
        return null;
    }

    deleteBook(id) {
        this.books = this.books.filter(book => book.id !== parseInt(id));
    }

    getAllBooks() {
        return this.books;
    }

    getBookById(id) {
        return this.books.find(book => book.id === parseInt(id));
    }

    generateId() {
        return Math.floor(Math.random() * 1000000);
    }
}

$(document).ready(function() {
    const library = new Library();

    // Function to add a book to the table
    function addBookToTable(book) {
        const table = $("#bookTable tbody");
        const row = `
            <tr id="book-${book.id}">
                <td>${book.title}</td>
                <td>${book.author}</td>
                <td>${book.publisher}</td>
                <td>${book.year}</td>
                <td>${book.edition}</td>
                <td>${book.quantity}</td>
                <td>${book.genre}</td>
                <td>
                    <button class="mb-1 btn btn-sm btn-warning editBtn" data-id="${book.id}">
                        Edit
                    </button>
                    <button class="mb-1 btn btn-sm btn-danger deleteBtn" data-id="${book.id}">
                        Delete
                    </button>
                </td>
            </tr>
        `;
        table.append(row);
    }

    // Function to clear the form
    function clearForm() {
        $("#bookForm")[0].reset();
    }

    // Function to read all books and display in table
    function readBooks() {
        const table = $("#bookTable tbody");
        table.empty();
        library.getAllBooks().forEach(book => {
            addBookToTable(book);
        });
    }

    // Add book form submit event
    $("#bookForm").on("submit", function(event) {
        event.preventDefault();
        const title = $("#bookTitle").val();
        const author = $("#author").val();
        const publisher = $("#publisher").val();
        const year = $("#year").val();
        const edition = $("#edition").val();
        const quantity = $("#quantity").val();
        const genre = $("#genre").val();

        const newBook = library.addBook(title, author, publisher, year, edition, quantity, genre);
        addBookToTable(newBook);
        clearForm();
    });

    // Clear all books
    $("#clearBtn").on("click", function() {
        if (confirm("Are you sure you want to clear all books?")) {
            library.books = [];
            readBooks();
        }
    });

    // Edit book
    $(document).on("click", ".editBtn", function() {
        const bookId = $(this).data("id");
        const book = library.getBookById(bookId);
        if (book) {
            $("#editBookId").val(book.id);
            $("#editBookTitle").val(book.title);
            $("#editAuthor").val(book.author);
            $("#editPublisher").val(book.publisher);
            $("#editYear").val(book.year);
            $("#editEdition").val(book.edition);
            $("#editQuantity").val(book.quantity);
            $("#editGenre").val(book.genre);
            $("#editModal").modal("show");
        }
    });

    // Save edited book
    $("#editForm").on("submit", function(event) {
        event.preventDefault();
        const id = $("#editBookId").val();
        const title = $("#editBookTitle").val();
        const author = $("#editAuthor").val();
        const publisher = $("#editPublisher").val();
        const year = $("#editYear").val();
        const edition = $("#editEdition").val();
        const quantity = $("#editQuantity").val();
        const genre = $("#editGenre").val();

        const updatedBook = {
            title,
            author,
            publisher,
            year,
            edition,
            quantity,
            genre
        };

        const book = library.editBook(id, updatedBook);
        if (book) {
            const row = $(`#book-${book.id}`);
            row.find("td:eq(0)").text(book.title);
            row.find("td:eq(1)").text(book.author);
            row.find("td:eq(2)").text(book.publisher);
            row.find("td:eq(3)").text(book.year);
            row.find("td:eq(4)").text(book.edition);
            row.find("td:eq(5)").text(book.quantity);
            row.find("td:eq(6)").text(book.genre);
            $("#editModal").modal("hide");
        }
    });

    // Delete book
    $(document).on("click", ".deleteBtn", function() {
        const bookId = $(this).data("id");
        if (confirm("Are you sure you want to delete this book?")) {
            library.deleteBook(bookId);
            $(`#book-${bookId}`).remove();
        }
    });

    // Initial load of books
    readBooks();
});
