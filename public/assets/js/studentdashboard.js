$(".share-button").on("click", function () {
    var qrText =
        "https://etikkurul.nisantasi.edu.tr/query-etikkurul/" +
        $(this).data("id");

    Swal.fire({
        title: "Genel başvuru sorgulama linkiniz",
        html: `
        <div id="qrcode" class="w-full flex items-center flex-col justify-center gap-4">
            <div>Bu linki paylaşabilirsin</div>
            <button class="copy-button flex gap-3 border-2 hover:border-black transition-colors rounded-md p-3 cursor-pointer items-center btn btn-primary" data-qrtext="${qrText}">Linki Kopyala
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-clipboard" viewBox="0 0 16 16">
<path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
<path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
</svg></button>
        </div>
    `,
        didOpen: function () {
            new QRCode(document.getElementById("qrcode"), {
                text: qrText,
                width: 256,
                height: 256,
                colorDark: "black",
                colorLight: "white",
                correctLevel: QRCode.CorrectLevel.H,
            });

            $(".copy-button").on("click", function () {
                var qrText = $(this).data("qrtext");
                navigator.clipboard.writeText(qrText).then(
                    function () {
                        /* clipboard successfully set */
                        Swal.fire("Kopyalandı!", "", "success");
                    },
                    function () {
                        /* clipboard write failed */
                        Swal.fire("Failed to copy", "", "error");
                    }
                );
            });
        },
    });
});
function hideAnnouncement() {
    $(".announcement").hide();
}
