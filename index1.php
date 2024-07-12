<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: index1.php");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .nav-bar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="nav-bar">
        <a href="logout.php" class="btn btn-warning">Logout</a>
        <h1 class="text-center">Library Management System</h1>
    </nav>
    <div class="container">
        <p>Welcome to Dashboard, you are logged in as: <?php echo $_SESSION["user"]; ?></p>
        <form action="#" id="bookForm">
            <div class="form-group mb-3">
                <label for="bookTitle">Book Title:</label>
                <input type="text" id="bookTitle" class="form-control" placeholder="Enter Book title" required>
            </div>
            <div class="form-group mb-3">
                <label for="author">Author:</label>
                <input type="text" id="author" class="form-control" placeholder="Enter Author Name" required>
            </div>
            <div class="form-group mb-3">
                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" class="form-control" placeholder="Enter Publisher Name" required>
            </div>
            <div class="form-group mb-3">
                <label for="year">Year:</label>
                <input type="text" id="year" class="form-control" placeholder="Enter Year" required>
            </div>
            <div class="form-group mb-3">
                <label for="edition">Edition:</label>
                <input type="text" id="edition" class="form-control" placeholder="Enter Edition" required>
            </div>
            <div class="form-group mb-3">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" class="form-control" placeholder="Enter Quantity" required>
            </div>
            <div class="form-group mb-3">
                <label for="genre">Genre:</label>
                <select id="genre" class="form-control" required>
                    <option value="">Select Genre</option>
                    <option value="Comics">Comics</option>
                    <option value="Novels">Novels</option>
                    <option value="Textbooks">Textbooks</option>
                    <option value="Study Materials">Study Materials</option>
                    <option value="Magazines">Magazines</option>
                </select>
            </div>
            <div class="mb-3">
                <button class="btn btn-success mx-2" type="submit" id="addBtn">Add Book</button>
                <button class="btn btn-warning mx-2" type="button" id="clearBtn">Clear All</button>
            </div>
        </form>
        
        <table class="table mt-4" id="bookTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Edition</th>
                    <th>Quantity</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editBookId">
                        <div class="form-group mb-3">
                            <label for="editBookTitle">Book Title:</label>
                            <input type="text" id="editBookTitle" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editAuthor">Author:</label>
                            <input type="text" id="editAuthor" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editPublisher">Publisher:</label>
                            <input type="text" id="editPublisher" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editYear">Year:</label>
                            <input type="text" id="editYear" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editEdition">Edition:</label>
                            <input type="text" id="editEdition" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editQuantity">Quantity:</label>
                            <input type="number" id="editQuantity" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editGenre">Genre:</label>
                            <select id="editGenre" class="form-control" required>
                                <option value="">Select Genre</option>
                                <option value="Comics">Comics</option>
                                <option value="Novels">Novels</option>
                                <option value="Textbooks">Textbooks</option>
                                <option value="Study Materials">Study Materials</option>
                                <option value="Magazines">Magazines</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="library.js"></script>
</body>
</html>
