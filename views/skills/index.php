<?php
session_start();

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

$urlLogin = $protocol . $_SERVER['HTTP_HOST'] .  "/";

if (!isset($_SESSION['user'])) {
    return header('Location: ' . $urlLogin);
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users - Web Porto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/views/users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/views/skills">Skills</a>
                    </li>
                </ul>
            </div>
            <form class="d-flex" id="logout">
                <button class="btn btn-primary" type="submit">Logout</button>
            </form>
        </div>
    </nav>


    <div class="container">
        <div id="message">
        </div>

        <h1 class="mt-4 mb-4 text-center text-primary">Skills CRUD</h1>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9">Skills</div>
                    <div class="col col-sm-3">
                        <button type="button" id="add_data" class="btn btn-success btn-sm float-end">Add</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="sample_data">
                        <thead>
                            <tr>
                                <th>Id </th>
                                <th>User </th>
                                <th>Skill Name</th>
                                <th>Rating</th>
                                <th>Description</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <script>
        const Host = window.location.protocol + '//' + window.location.host;
        const UrlLogout = Host + '/api/auth/logout.php';
        const UrlLogin = Host + '/';
        const UrlReadSkills = Host + '/api/skills/read.php';

        $(document).ready(function() {

            showAll();

            $('#logout').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: UrlLogout,
                    method: "POST",
                    success: function(data) {
                        window.location.href = UrlLogin;
                    },
                    error: function(err) {
                        console.log(err);
                        $('#message').html('<div class="alert alert-danger">' + err.responseJSON + '</div>');
                    }
                });
            });
        });


        // Fungsi untuk memangil api list skills 
        function showAll() {
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: UrlReadSkills,
                success: function(response) {

                    console.log(response);
                    var json = response.body;
                    var dataSet = [];

                    for (var i = 0; i < json.length; i++) {
                        var sub_array = {
                            'id': json[i].id,
                            'user': json[i].user_name,
                            'skill_name': json[i].skill_name,
                            'rating': json[i].rating,
                            'description': json[i].description,
                            'action': '<button onclick="showOne(' + json[i].id + ')" class="btn btn-sm btn-warning mr-1">Edit</button>' +
                                '<button onclick="deleteOne(' + json[i].id + ')" class="btn btn-sm btn-danger ml-1">Delete</button>'
                        };
                        dataSet.push(sub_array);
                    }

                    $('#sample_data').DataTable({
                        data: dataSet,
                        columns: [{
                                data: "id"
                            },
                            {
                                data: "user"
                            },
                            {
                                data: "skill_name"
                            },
                            {
                                data: "rating"
                            },
                            {
                                data: "description"
                            },
                            {
                                data: "action"
                            }
                        ]
                    });
                },

                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>

</body>
