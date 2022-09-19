<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">

    <div class="text-center pt-5">

        <button id="create-user" type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                data-bs-target="#createUserModal">
            Create
        </button>


    </div>


    <table class="table" id="user-table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Position</th>
            <th scope="col">Position Id</th>
            <th scope="col">Registration timestamp</th>
            <th scope="col">Photo</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="text-center">
        <button id="loadMoreUsersButton" type="button" class="btn btn-primary">
            Load more
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input name="phone" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position Id</label>
                        <select name="position_id" class="form-control">
                            <option>Select</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input name="file" type="file" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="createUser" type="button" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>


@vite(['resources/scss/app.scss', 'resources/js/app.js'])
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
            let shouldNoMoreUsersRequest = false;
            let currentPage = 1;

            loadMoreUsers();
            loadPositions();


            $('#loadMoreUsersButton').on('click', loadMoreUsers);

            $('#createUser').on('click', function () {
                let form = $('#createUserForm').serializeArray();
                let data = [];

                form.forEach(function (input) {

                    data[input.name] = input.value
                })

                sendPostRequest(data);
            })

            function loadPositions() {
                $.ajax({
                    url: '{{ route('api.get-positions') }}',
                    method: 'GET',
                    success: function (resp) {
                        resp.positions.forEach(function (pos) {
                            $('select[name="position_id"]').append(`<option value="${pos.id}">` +
                                pos.name +
                                '</option>')
                        })
                    }
                })
            }

            function loadMoreUsers() {
                if (shouldNoMoreUsersRequest) {
                    return false;
                }
                let data = makeRequestForUsers();

                console.log(data)
                if (data.total_pages > currentPage) {
                    currentPage++;
                } else {
                    shouldNoMoreUsersRequest = true;
                    alert('last page!')
                }

                data.users.forEach(function (user) {
                    addUserToTable(user)
                })
            }

            function addUserToTable(user) {
                $('#user-table tbody').append('<tr>' +
                    `<td>${user.id}</td>` +
                    `<td>${user.name}</td>` +
                    `<td>${user.email}</td>` +
                    `<td>${user.phone}</td>` +
                    `<td>${user.position_id}</td>` +
                    `<td>${user.position}</td>` +
                    `<td>${user.registration_timestamp}</td>` +
                    `<td>${user.photo}</td>` +
                    '<tr/>')
            }

            function makeRequestForUsers() {
                return JSON.parse($.ajax({
                    url: '{{ route('api.users.index') }}',
                    data: {
                        count: 6,
                        page: currentPage,
                    },
                    type: 'GET',
                    async: false,
                }).responseText)
            }

            function sendPostRequest(data) {
                console.log(data)
                let token = getToken().token;

                var formData = new FormData();
                var fileField = document.querySelector('input[type="file"]');
                formData.append('position_id', data.position_id);
                formData.append('name', data.name);
                formData.append('email', data.email);
                formData.append('phone', data.phone);
                formData.append('photo', fileField.files[0]);
                fetch(
                    'http://localhost/api/users',
                    {
                        method: 'POST', body: formData, headers: {
                            'token': token,
                        },
                    }).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    console.log(data);
                    if (data.success) {
                        // window.location.reload()
                    }
                })
            }

            function getToken() {
                return JSON.parse($.ajax({
                    url: '{{ route('api.get-token') }}',
                    type: 'GET',
                    async: false,
                }).responseText)
            }
        }
    )
</script>
</body>
</html>
