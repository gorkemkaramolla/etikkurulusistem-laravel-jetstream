<x-app-layout class="">

    <div class="w-full flex  lg:flex-row flex-col mx-auto container  gap-3">
        <div class="lg:w-2/6 px-6 relative w-full bg-white my-4 py-8 shadow-xl rounded-xl ">
            <h1 class="text-2xl text-center font-extrabold">Yeni Kullanıcı Oluştur</h1>
            <form action="" id="create-user-form" class=" flex flex-col gap-3 ">
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
                <x-input required type="password" id="password" name="password" />
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

        <div class="lg:w-2/6 px-6  w-full">
            <div class="bg-white my-4 py-8 shadow-xl rounded-xl ">
                <h1 class="text-2xl text-center font-extrabold">Kullanıcılar</h1>
                <select name="" id="filterUserRole">
                    <option value="etik_kurul">Etik Kurul Üyeleri</option>
                    <option value="student">Öğrenciler</option>
                    <option value="academic">Akademisyenler</option>
                    <option value="sekreterlik">Sekreterler</option>
                </select>
                <div class=" ">
                    @foreach ($users as $user)
                        <div data-role="{{ $user->role }}"
                            class=" flex flex-row userData flex-wrap justify-between items-center px-4 py-2 rounded-xl">
                            <div class="flex flex-col gap-1">
                                <span class="font-bold">{{ $user->name }} {{ $user->lastname }}</span>
                                <span class="text-sm">{{ $user->email }}</span>
                            </div>
                            <div class="flex flex-row gap-2">
                                <button class="bg-custom-red text-white px-2 py-1 rounded-xl">Sil</button>
                                <button class="bg-blue-500 text-white px-2 py-1 rounded-xl">Düzenle</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="lg:w-1/6 px-6 w-full"></div>

    </div>
    <script>
        $(document).ready(function() {
            $('#filterUserRole').change(function() {
                var selectedRole = $(this).val();
                $('.userData').attr('style', 'display: none !important');

                $('.userData[data-role="' + selectedRole + '"]').show();
            });
        });
    </script>
</x-app-layout>
