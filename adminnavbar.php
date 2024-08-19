<nav class="navbar navbar-expand-lg bg-white p-0 m-0">
    <div class="container-fluid">
        <img src="images/lmstitle.png" height="100px" class="col-sm-6 col-md-4"> 

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav "> 
                <li class="nav-item mx-2 fs-4">
                    <a class="nav-link" href="adminhome.php" target="_parent">Home</a>
                </li>
                <li class="nav-item mx-2 fs-4">
                    <a class="nav-link" href="allstudents.php" target="_parent">Users</a>
                </li>
                
                <li class="nav-item dropdown fs-4 mx-2">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Books
                    </a>
                    <div class="dropdown-menu login " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="addbook.php" target="_parent">Add Book</a>
                        <a class="dropdown-item" href="allbooks.php" target="_parent">All Books</a>
                        <a class="dropdown-item" href="allissuedbooks.php" target="_parent">Issued Books</a>
						
                    </div>
				 </li>
                <li class="nav-item dropdown fs-4 mx-2">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Transaction
                    </a>
                    <div class="dropdown-menu login " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="issuebook.php" target="_parent">Issue Book</a>
                        <a class="dropdown-item" href="returnbook.php" target="_parent">Return Book</a>
						
                    </div>
				 </li>
                <li class="nav-item mx-2 fs-4">
                    <a class="nav-link" href="adminprofile.php" target="_parent">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>