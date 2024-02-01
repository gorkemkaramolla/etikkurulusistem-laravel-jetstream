<x-app-layout>

    <div class="flex-col w-full">
        <div class="w-full flex  lg:flex-row flex-col mx-auto container justify-center  gap-3">
            <div class="lg:w-2/6 px-6 relative w-full  bg-white my-4 py-8 shadow-xl rounded-xl ">
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

            <div class=" lg:w-4/6 w-full">
                <div class="bg-white my-4 py-8 px-4 shadow-xl rounded-xl ">
                    <h1 class="text-2xl text-center font-extrabold">Kullanıcılar</h1>

                    <select name="" id="filterUserRole">
                        <option selected value="etik_kurul">Etik Kurul Üyeleri</option>
                        <option value="student">Öğrenciler</option>
                        <option value="academic">Akademisyenler</option>
                        <option value="sekreterlik">Sekreterler</option>
                        <option value="inactive">İnaktif Kullanıcılar</option>

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
                                    <tr class="border-t userData" data-is_user_active="{{ $user->is_user_active }}"
                                        data-role="{{ $user->role }}">
                                        <td class="px-4 py-2">{{ $user->id }}</td>

                                        <td class="px-4 py-2">{{ $user->name }} {{ $user->lastname }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">{{ $user->username }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-3">
                                                @if ($user->is_user_active == '0')
                                                    <form class="activate-user-form" method="POST"
                                                        action="/api/set-user-status/activate/{{ $user->id }}">

                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-green-500 text-white px-3  py-1 rounded-xl">Aktif
                                                            Et</button>
                                                    </form>
                                                @else
                                                    <form class="inactivate-user-form" method="POST"
                                                        action="/api/set-user-status/inactivate/{{ $user->id }}">

                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-custom-red text-white px-3  py-1 rounded-xl">İnaktif
                                                            Et</button>
                                                    </form>
                                                @endif
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
            <script>
                var users = @json($users);
                console.log(users)
                var csrfToken = "{{ csrf_token() }}";
            </script>
            <script src="{{ asset('assets/js/adminfeatures.js') }}"></script>
            <style>
                @media screen and (max-width: 768px) {
                    .fixed-height-table-container {
                        overflow-x: auto;
                        display: block;
                    }
                }
            </style>

        </div>
        <div class="w-full container border-2 p-8 mx-auto">
            <button class="my-4 text-xl text-custom-red accordion-button">Show/Hide Form and Programs List / Formu ve
                Program
                Listesini
                Göster/Gizle</button>

            <div class="accordion-content hidden w-full  lg:flex-row flex-col  gap-3">
                <h1 class="text-2xl my-4">Ana Bilim Dalı ve Program Güncelleme</h1>

                <form class="w-full" action="/api/enums" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="parent" class="block text-gray-700 text-sm font-bold mb-2">Department/Ana Bilim
                            Dalı:</label>
                        <x-input class="w-full" type="text" id="parent" name="parent" />
                    </div>
                    <div class="mb-4">
                        <label for="field" class="block text-gray-700 text-sm font-bold mb-2">Program:</label>
                        <x-input class="w-full" type="text" id="field" name="field" />
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Yeni Anabilim dalı ve program ekle
                    </button>
                </form>
                <div class="flex flex-col gap-3 justify-center">
                    <div class="overflow-auto">
                        <table class="w-full table-auto">
                            <h2 class="text-xl my-4">Güncel Programlar Listesi</h2>

                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Ana Bilim Dalı / <i>Department</i></th>
                                    <th class="px-4 py-2">Program</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs->fields as $parent => $fieldArray)
                                    <tr>
                                        <td class="border flex gap-8 px-4 py-2">
                                            <button class="ml-2 py-1 px-2 bg-blue-500 text-white rounded"
                                                onclick="fillParentInput('{{ $parent }}')">Seç</button>
                                            <button type="button"
                                                class="ml-2 py-1 px-2 bg-red-500 text-white rounded"
                                                onclick="deleteRow('{{ $parent }}')">Delete</button>
                                            <span>
                                                {{ $parent }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">{{ implode(', ', $fieldArray) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function fillParentInput(parent) {
                document.getElementById('parent').value = parent;
            }

            function deleteRow(parent) {
                Swal.fire({
                    title: 'Emin misin?',
                    text: "Bu işlem geri alınamaz!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, sil!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/api/enums',
                            type: 'DELETE',
                            data: {
                                parent: parent,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Kayıt başarıyla silindi.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                })
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error!',
                                    'Kayıt silinirken bir hata oluştu',
                                    'error'
                                )
                            }
                        });
                    }
                })
            }

            document.querySelector('.accordion-button').addEventListener('click', function() {
                var content = document.querySelector('.accordion-content');
                content.classList.toggle('hidden');
                if (!content.classList.contains('hidden')) {
                    content.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            });
        </script>

        <style>
            .hidden {
                display: none;
            }
        </style>
</x-app-layout>
