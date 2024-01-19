<x-guest-layout>
    <style>
        table {
            width: 100%;
            max-width: 1024px;
            min-width: 300px;
            height: 100px;
            font-size: 16px;
        }

        td {
            word-wrap: break-word;
            /* or use overflow-wrap: break-word; */
            max-width: 200px;
            /* Set a specific max-width if needed */
        }

        @media (max-width: 500px) {
            .pdf-render {}
        }
    </style>
    <div class="pdf-render w-full border-collapse flex flex-col items-center  overflow-y-hidden  p-0 my-8 ">
        @if ($form['stage'] === 'onaylandi')
            <table>
                <tr>
                    <th class="w-2/12" colspan="1">
                        <img src="/assets/images/logo-nisantasi.png" class="w-full ">
                    </th>
                    <th>T.C.
                        İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ REKTÖRLÜĞÜ
                        ETİK KURULU
                    </th>
                    <th class="font-normal p-0 m-0 ">
                        <div class="p-0 m-0 border-b-2">
                            <p class="p-0 m-0 ">Evrak Tarihi</p>
                            <p class="p-0 m-0  ">
                                {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') }}

                            </p>

                        </div>
                        <div class="p-0 m-0">
                            <p>
                                Evrak Numarası
                            </p>
                            <p>{{ $form['id'] }}</p>

                        </div>
                    </th>
                </tr>
                <tbody>
                    <td class="" colspan="3">

                        <div class="flex flex-col py-12 w-full gap-12">
                            <span>
                                <span>Sayın &nbsp;</span>

                                <div class="inline-flex flex-col">
                                    <span class="font-extrabold"> {{ $form['name'] }} {{ $form['lastname'] }}</span>
                                    <span>
                                        İstanbul Nişantaşı Üniversitesi
                                    </span>
                                    <span>
                                        Lisansüstü Eğitim Enstitüsü
                                    </span>
                                    <span>
                                        {{ $form['program'] }}
                                    </span>
                                </div>
                            </span>

                            <div class="flex flex-col gap-12">
                                <div class="flex flex-col gap-12">
                                    <p class="indent-14">
                                        İstanbul Nişantaşı Üniversitesi, Etik Kurulu Başkanlığına
                                        {{ $form['created_at'] }}
                                        tarihinde
                                        incelenmek üzere
                                        başvurmuş olduğunuz <span
                                            class="font-extrabold">“{{ $form['research_title'] }}”</span> başlıklı
                                        çalışmanız,
                                        {{ \Carbon\Carbon::parse($form['conclusion_date'])->format('d/m/Y') }}
                                        tarihli 2024/{{ $form['id'] }} numaralı etik kurul toplantısında
                                        değerlendirilmiştir.
                                        Kurulumuz
                                        tarafından
                                        yapacağınız araştırmanın etik açıdan uygunluğuna oy birliğiyle karar
                                        verilmiştir.
                                    </p>
                                    <p>
                                        Bilgilerinize rica ederim.

                                    </p>
                                </div>

                                <p class=" flex-col w-full flex items-end">
                                    <span>
                                        04.01.2024

                                    </span>
                                    <span>
                                        Doç. Dr. Gözde MERT
                                    </span>
                                    <span>
                                        Etik Kurulu Başkanı

                                    </span>
                                </p>
                            </div>
                        </div>
                    </td>
                </tbody>
            </table>
            <table>
                <thead>
                    <th colspan="4" class="bg-gray-100 ">
                        Başvuru Bilgileri</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Araştırmacılar</td>
                        <td>{{ $form['name'] . ' ' . $form['lastname'] }} </td>
                        <td>Başvuru Tarihi</td>
                        <td>
                            {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') }}

                        </td>
                    </tr>
                    <tr>
                        <td>Danışman Yürütücü</td>
                        <td>{{ $form['advisor'] }}</td>
                        <td>Araştırma Türü</td>
                        <td>{{ $form['research_type'] }}</td>
                    </tr>
                    <tr>
                        <td>Progrma/Alan</td>
                        <td>{{ $form['program'] }}</td>
                        <td>Etik Kurul Toplantı Tarihi</td>
                        <td>Bu alan doldurulacak</td>
                    </tr>
                    <tr>
                        <td>Çalışma Niteliği</td>
                        <td>{{ $form['work_qualification'] }}</td>
                        <td>Etik Kurul Karar No</td>
                        <td>Doldurulacak</td>
                    </tr>
                </tbody>
            </table>
        @else
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

            <div class="d-flex justify-content-center align-items-center">
                <div class="card" style="width: 50rem;">
                    <div class="card-body">
                        <h1 class="card-title">Sayın Kullanıcı,</h1>
                        <p class="card-text">Başvurunuz tarafımıza ulaşmış olup, değerlendirme sürecine alınmıştır. Bu
                            süreç, başvurunuzun detaylarına bağlı olarak biraz zaman alabilir. Başvurunuz
                            sonuçlandığında, sonuçları bu bağlantı üzerinden görüntüleyebilirsiniz. Ayrıca, bu
                            bağlantıyı genel erişime açık bir şekilde paylaşabilirsiniz. Anlayışınız için teşekkür
                            ederiz.</p>
                        <p class="card-text">Başvurunuzun durumunu takip etmek için lütfen başvuruda bulunduğunuz
                            hesabınıza giriş yapınız.</p>
                        <p class="card-text">Herhangi bir sorunuz veya yardıma ihtiyacınız olursa, lütfen bizimle
                            iletişime geçiniz. Sorularınıza yanıt vermekten memnuniyet duyarız.</p>
                        <p class="card-text">İyi günler diler, çalışmalarınızda başarılar temenni ederiz.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <style>
        table {
            border-collapse: collapse !important;
            width: 100%;
            max-width: 1024px;
            min-width: 300px;
            height: 100px;
            font-size: 16px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
</x-guest-layout>
