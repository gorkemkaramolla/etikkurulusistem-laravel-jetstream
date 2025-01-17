@props(['formData' => null])

<div class="my-3 p-3 bg-body  w-100 rounded ">
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Araştırmanın Başlığı |
        Title
        of the
        Research</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required id="longparagraf-1" name="research_title" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;"
            rows="3"
            placeholder="Başlıkta karşılaştırdığınız olgular veya incelediğiniz konu anlaşılabilir düzeyde yer almalıdır. | The facts you are comparing or the subject you are examining should be included in the title at an understandable level.">{{ trim($formData ? $formData->research_title : old('research_title')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Konu ve Amaç | Subject and Purpose</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required id="longparagraf-2" name="research_subject_purpose" class="form-control pt-0 pb-0 mb-2"
            style=" overflow: hidden;" rows="8"
            placeholder="“Ne”yi araştırıyorsunuz? Net bir biçimde araştırma konunuzu yazınız. Unutmayın ilk cümle açıklayıcı olmalı ve ilk cümlede sizin neyi araştırdığınızı okuyan kişi anlamalı. Sonraki cümlelerde yorum yapılabilir ve daha fazla açıklanabilir.“Niçin” araştırıyorsunuz? Net bir biçimde araştırmanın amacını yazınız. Araştırmanın amacı ile konusu genelde karıştırılır. Araştırmanın konusunda ilgilendiğiniz sorunu açıklarsınız, araştırmanın amacında ise bunu neden yaptığınızı veya neden bu konuyu seçtiğinizi açıklarsınız.
“What” are you investigating? Write your research topic clearly. Remember, the first sentence should be descriptive and the person reading it should understand what you are researching in the first sentence. Comments can be made and further explained in the following sentences. “Why” are you investigating? Write clearly the purpose of the research. The purpose of the research and its subject are often confused. In the subject of the research, you explain the problem you are interested in, and in the purpose of the research, you explain why you are doing this or why you chose this topic. ">{{ trim($formData ? $formData->research_subject_purpose : old('research_subject_purpose')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Özgün Değer | Unique Value </label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required id="longparagraf-3" name="research_unique_value" class="form-control pt-0 pb-0 mb-2form-control mb-2"
            style=" overflow: hidden;" rows="6"
            placeholder="Yapacağınız bu araştırma neden önemli? Bu araştırmayı diğerlerinden ayıran yanları neler? Kısa ve net cümlelerle bu araştırmanın literatüre katkılarından bahsedin. Literatür haricinde bilim dünyasına veya insanlığa çok özel bir katkısı olacaksa lütfen belirtiniz.
Why is this research important? What distinguishes this research from others? Mention the contributions of this research to the literature in short and clear sentences. Please indicate if it will make a very special contribution to the world of science or humanity other than literature.">{{ trim($formData ? $formData->research_unique_value : old('research_unique_value')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Hipotezler / Araştırma Soruları | Hypothesis / Research
        Questions</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_hypothesis" id="longparagraf-2" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;"
            rows="4"
            placeholder="Araştırmanın niteliğine göre belirlediğiniz araştırma soruları veya hipotezleri yazınız.
Write the research questions or hypotheses you have determined according to the nature of the research.">{{ trim($formData ? $formData->research_hypothesis : old('research_hypothesis')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Yöntem | Method</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_method" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="6"
            placeholder="“Nasıl” araştırıyorsunuz?  Bu kısmı yazarken hangi araştırma yöntemini seçtiğinizi, araştırma yönteminin dayandığı bilim paradigmasını, yöntemin hangi tekniği gerektirdiği ve sizin çalışmanızda hangi tekniği kullanacağınızı, neden bu tekniği seçtiğinizi net biçimde yazmanız gerek.
While writing this part, you need to clearly write which research method you chose, the scientific paradigm on which the research method is based, which technique the method requires, which technique you will use in your study, and why you chose this technique.">{{ trim($formData ? $formData->research_method : old('research_method')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Evren ve Örneklem | Universe and Sample</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="4" name="research_universe"
            placeholder="Araştırmanın evrenini ve bu evren içinden örneklemi nasıl seçtiğinizi yazınız. Hangi örnekleme türünü kullandığınızı yazınız.
Write the population of the research and how you chose the sample from this population. Please write which type of sampling you used.">{{ trim($formData ? $formData->research_universe : old('research_universe')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Ölçek ve Formlar | Scale and Forms</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_forms" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="4"
            placeholder="Araştırmada kullanılacak ölçek ve formların kaynağını yazınız.
Write the source of the scales and forms to be used in the research.">{{ trim($formData ? $formData->research_forms : old('research_forms')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Verilerin Toplanması ve Analizi | Data Collection and
        Analysis</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_data_collection" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="4"
            placeholder="Araştırmada kullanılacak olan her ölçme aracına yönelik detaylı bilgi ayrı başlıklar halinde verilmelidir.
Detailed information about each measurement tool to be used in the research should be given under separate headings.">{{ trim($formData ? $formData->research_data_collection : old('research_data_collection')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Sınırlar ve Kısıtlar | Boundaries and Restrictions</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_restrictions" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="4"
            placeholder="Araştırmanızın alanını ve konusunu nasıl sınırlandırdınız ve araştırmayı uygulamaya yönelik temel kısıtlar nelerdir?
How did you delimit the scope and topic of your research and what are the main constraints on applying the research?">{{ trim($formData ? $formData->research_restrictions : old('research_restrictions')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Araştırma Tarih ve Yeri | Research Date and Place</label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_place_date" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;" rows="4"
            placeholder="Araştırmanın (varsa) saha çalışmasını ne zaman ve nerede gerçekleştireceğinize dair araştırma takvimi oluşturunuz.
Create a research calendar for when and where you will conduct field work (if any).">{{ trim($formData ? $formData->research_place_date : old('research_place_date')) }}</textarea required>
    </div>
    <label class="rounded   py-2 bg-primary text-white my-1 border px-2 ">Faydalanılacak Kaynaklar/Literatür Taraması | Sources to
        Use/Literature Review </label>
    <div class="d-flex text-body-secondary pt-1">
        <textarea required name="research_literature_review" class="form-control pt-0 pb-0 mb-2" style=" overflow: hidden;"
            rows="4"
            placeholder="Araştırma konusuyla ilgili kaynaklar Nişantaşı Üniversitesi Lisansüstü Eğitim Enstitüsü Tez Yazım Kılavuzuna uygun şekilde verilmelidir. Kaynakça listesi olarak yazılmalıdır. Kılavuzu lee.nisantasi.edu.tr adresinden edinebilirsiniz.
Sources related to the research topic should be given in accordance with the Nişantaşı University Graduate Education Institute Thesis Writing Guide. It should be written as a list of references. You can obtain the guide from lee.nisantasi.edu.tr. ">{{ trim($formData ? $formData->research_literature_review : old('research_literature_review')) }}</textarea>
    </div>
</div>
