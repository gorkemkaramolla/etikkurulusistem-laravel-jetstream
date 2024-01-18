<x-app-layout>

    <div class="w-full flex  lg:flex-row flex-col mx-auto container  gap-3">
        <div class="lg:w-2/6 px-6 relative w-full bg-white my-4 py-8 shadow-xl rounded-xl ">
            <h1 class="text-2xl text-center font-extrabold">Yeni Kullanıcı Oluştur</h1>
            <form action="/api/add-new-user" method="POST" id="create-user-form" class=" flex flex-col gap-3 ">
                @csrf
                <label for="role">Yetki</label>
                <select name="role" id="role">
                    <option value="student">Öğrenci</option>
                    <option value="academic">Akademisyen</option>
                    <option value="sekreterlik">Sekreter</option>
                    <option value="etik_kurul">Etik Kurul Üyesi</option>
                </select>
                <label for="username">Kullanıcı Adı</label>
                <x-input required type="text" id="username" name="username" />
                <label for="password">Parola</label>
                <div class="relative">
                    <x-input class="w-full" required type="password" id="password" name="password" />
                    <button
                        type="button"class="pw-unvisible absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </button>
                    <button type="button"
                        class="pw-visible hidden absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </button>

                </div>
                <div class="flex w-full gap-2  justify-center">
                    <div class="flex flex-col w-1/2">
                        <label for="name">İsim</label>
                        <x-input required type="text" id="name" name="name" />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="lastname">Soyisim</label>
                        <x-input required type="text" id="lastname" name="lastname" />
                    </div>
                </div>
                <label for="email">Email</label>
                <x-input required type="email" id="email" name="email" />
                <label for=""></label>
                <x-button class="py-3 flex justify-between" type="submit">Yeni Kullanıcı Oluştur
                    <svg fill="white" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960"
                        width="18">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                    </svg>

                </x-button>
            </form>
        </div>

        <div class="lg:w-4/6 px-6  w-full">
            <div class="bg-white my-4 py-8 px-4 shadow-xl rounded-xl ">
                <h1 class="text-2xl text-center font-extrabold">Kullanıcılar</h1>
                <select name="" id="filterUserRole">
                    <option selected value="etik_kurul">Etik Kurul Üyeleri</option>
                    <option value="student">Öğrenciler</option>
                    <option value="academic">Akademisyenler</option>
                    <option value="sekreterlik">Sekreterler</option>
                </select>
                <div id="table-container" class="fixed-height-table-container">

                    <table id="myTable" class=" table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>

                                <th class="px-4 py-2">Ad</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Kullanıcı Adı</th>

                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-t userData" data-role="{{ $user->role }}">
                                    <td class="px-4 py-2">{{ $user->id }}</td>

                                    <td class="px-4 py-2">{{ $user->name }} {{ $user->lastname }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->username }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex gap-3">
                                            <form class="delete-user-form" method="POST"
                                                action="/delete-user/{{ $user->id }}">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-custom-red text-white px-2 py-1 rounded-xl">Sil</button>
                                            </form>
                                            <button
                                                class="edit-button bg-blue-500 text-white px-2 py-1 rounded-xl">Düzenle</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="lg:w-1/6 px-6 w-full"></div>

    </div>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "responsive": true,
                "pageLength": 5,
                "lengthChange": false,
                "info": false,
                "dom": 'lfrtip',
                "ordering": false
            });

            // Filter the table based on the selected role when the page loads
            var selectedRole = $('#filterUserRole').val();
            filterTable(selectedRole);

            $('#filterUserRole').change(function() {
                var selectedRole = $(this).val();
                filterTable(selectedRole);
            });

            function filterTable(role) {
                $.fn.dataTable.ext.search.pop();
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var rowRole = table.row(dataIndex).node().getAttribute('data-role');
                        return rowRole === role;
                    }
                );
                table.draw();
            }
            $(document).on('click', '#myTable .edit-button', function() {


                event.preventDefault(); // Prevent the button from causing a page reload
                var data = table.row($(this).parents('tr')).data();
                var users = @json($users);

                var userId = data[0];
                // Subtract 1 from the userId to get the correct array index
                var userIndex = userId - 1;

                var userName = users[userIndex].name;
                var userLastName = users[userIndex].lastname;
                var userEmail = users[userIndex].email;
                var userUsername = users[userIndex].username;
                var userRole = users[userIndex].role;

                Swal.fire({
                    title: 'Kullanıcı Bilgilerini Düzenle',
                    html: `
    <form id="editUserForm" class="text-start space-y-4 p-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Yetki</label>

        <select id="role" name="role" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="student" ${userRole === 'student' ? 'selected' : ''}>Öğrenci</option>
            <option value="academic" ${userRole === 'academic' ? 'selected' : ''}>Akademisyen</option>
            <option value="sekreterlik" ${userRole === 'sekreterlik' ? 'selected' : ''}>Sekreterlik</option>
        <option value="etik_kurul" ${userRole === 'etik_kurul' ? 'selected' : ''}>Etik Kurul</option>
        
        </select>
        <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
        <input type="text" placeholder="Bu alan boş" id="username" name="username" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userUsername?userUsername:""}">
        <label for="name" class="block text-sm font-medium text-gray-700">İsim</label>
        <input type="text" id="name" name="name" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userName}">
        <label for="name" class="block text-sm font-medium text-gray-700">Soy İsim</label>
        <input type="text" id="lastname" name="lastnamename" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userLastName}">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userEmail}">
    </form>
`,
                    confirmButtonText: 'Değişiklikleri Kaydet',
                    showCloseButton: true,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    preConfirm: () => {
                        let username = Swal.getPopup().querySelector('#username').value;
                        let name = Swal.getPopup().querySelector('#name').value;
                        let email = Swal.getPopup().querySelector('#email').value;
                        let lastname = Swal.getPopup().querySelector('#lastname').value;
                        let role = Swal.getPopup().querySelector('#role').value;

                        if (false) {
                            Swal.showValidationMessage(`Please enter all fields.`);
                        }
                        return {
                            username: username,
                            name: name,
                            email: email,
                            lastname: lastname, // Add a comma here
                            role: role,
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let username = result.value.username;
                        let name = result.value.name;
                        let email = result.value.email;
                        let lastname = result.value.lastname;
                        let role = result.value.role;
                        Swal.fire({
                            title: `${userId} ID'li kullanıcıyı güncellemek istediğinize emin misiniz?`,
                            text: "Kullanıcı bilgileri güncellenecek.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Onaylıyorum',
                            cancelButtonText: 'İptal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/api/edit-user/' + userId,
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    data: {
                                        username: username,
                                        name: name,
                                        email: email,
                                        lastname: lastname,
                                        role: role,
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Başarıyla!',
                                            'Kullanıcı bilgileri başarıyla değiştirildi.',
                                            'success'
                                        ).then(function() {
                                            location
                                                .reload(); // Reload the page to fetch the updated user list
                                        });
                                    },
                                    error: function(jqXHR, textStatus,
                                        errorThrown) {
                                        let errorMessage = jqXHR.responseJSON;
                                        console.log(errorMessage);
                                        Swal.fire(
                                            'Hata!',
                                            'Kullanıcı bilgileri güncellenirken bir hata oluştu: ' +
                                            errorMessage,
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('#create-user-form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '/api/add-new-user',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(data) {
                    if (data.error) {
                        Swal.fire({
                            title: "Hata",
                            text: data.error,
                            icon: "error",
                            confirmButtonText: 'Tamam',
                        });
                    } else {
                        Swal.fire({
                            title: "Başarılı",
                            text: data.success,
                            icon: "success",
                            confirmButtonText: 'Tamam',
                        }).then(function() {
                            location.reload(); // Reload the page to fetch the updated user list
                        });
                    }
                },
                error: function(error) {
                    var errorMessage = '';
                    $.each(error.responseJSON.errors, function(key, value) {
                        errorMessage += value + '\n';
                    });

                    Swal.fire({
                        title: "Hata",
                        text: 'Bir Hata Oluştu: ' + errorMessage,
                        icon: "error",
                        confirmButtonText: 'Tamam',
                    });
                }
            });
        });
        $('.delete-user-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from causing a page reload

            var actionUrl = $(this).attr('action');
            var userId = actionUrl.split('/').pop(); // Extract the user id from the action URL

            Swal.fire({
                title: "ID'si " + userId + " olan kullanıcıyı silmek istediğinize emin misiniz?",
                text: "Bu işlem geri alınamaz.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Hayır, iptal!',
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: this.action,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function(data) {
                            if (data.error) {
                                Swal.fire({
                                    title: "Error",
                                    text: data.error,
                                    icon: "error",
                                    confirmButtonText: 'OK',
                                });
                            } else {
                                Swal.fire({
                                    title: "Success",
                                    text: data.success,
                                    icon: "success",
                                    confirmButtonText: 'OK',
                                }).then(function() {
                                    location
                                        .reload(); // Reload the page to fetch the updated user list
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(".pw-unvisible").click(function() {
            $(this).toggleClass("hidden")
            $(".pw-visible").toggleClass("hidden");
            $("#password").attr("type", "text");
        });
        $(".pw-visible").click(function() {
            $(this).toggleClass("hidden");
            $(".pw-unvisible").toggleClass("hidden");
            $("#password").attr("type", "password");
        });
    </script>
    <style>
        @media screen and (max-width: 768px) {
            .fixed-height-table-container {
                overflow-x: auto;
                display: block;
            }
        }
    </style>

</x-app-layout>
