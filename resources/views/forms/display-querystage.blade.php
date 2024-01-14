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
    <div class="pdf-render w-full  flex flex-col items-center  overflow-y-hidden  p-0 my-8 ">
        <table>
            <tr>
                <th class="w-2/12" colspan="1">
                    <img src="/assets/images/logo-nisantasi.png" class="w-full ">
                </th>
                <th>T.C.
                    İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ REKTÖRLÜĞÜ
                    ETİK KURULU
                </th>
                <th>
                    <p class="p-0 m-0">Evrak Tarihi</p>
                    <p class="p-0 m-0">Evrak Numarası</p>
                </th>
            </tr>
            <tbody>
                <td class="" colspan="3">

                    <div class="flex flex-col w-full gap-12">
                        <span>Sayın &nbsp;</span>
                        <span>
                            <div class="inline-flex flex-col">
                                <span class="font-bold"> {{ $form['name'] }} {{ $form['lastname'] }}</span>
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
                                <p>
                                    İstanbul Nişantaşı Üniversitesi, Etik Kurulu Başkanlığına {{ $form['created_at'] }}
                                    tarihinde
                                    incelenmek üzere
                                    başvurmuş olduğunuz “{{ $form['research_title'] }}” başlıklı çalışmanız,
                                    04.01.2024 tarihli 2024/01 numaralı etik kurul toplantısında değerlendirilmiştir.
                                    Kurulumuz
                                    tarafından
                                    yapacağınız araştırmanın etik açıdan uygunluğuna oy birliğiyle karar verilmiştir.
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
            border: 1px solid black;
        }
    </style>
</x-guest-layout>
