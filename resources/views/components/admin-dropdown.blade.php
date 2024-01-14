@props(['trigger'])
<div class="">
    <x-button id="create-user">
        {{ $trigger }}
    </x-button>
    <div>
        {{ $slot }}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#create-user').click(function() {
            if ($('#create-user-form').hasClass('hidden')) {
                $('#create-user-form').hide().removeClass('hidden').fadeIn();
            } else {
                $('#create-user-form').fadeOut(function() {
                    $(this).addClass('hidden');
                });
            }
        })
    });
</script>
