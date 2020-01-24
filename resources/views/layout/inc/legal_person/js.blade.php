
<script>
    function toggleType(val) {
        if (val == "1") {
            $('input[name="type"]#pj').prop('checked', true);
            $('section.section-pf').hide();
            $('section.section-pj').fadeIn('fast');
            $('section.section-pj').find('input').not("input#exemption_ie,input#ie").attr('required', true);
            $('section.section-pf').find('input').attr('required', false);
//                $('section.section-pf').find('input').val("");
        } else {
            $('input[name="type"]#pf').prop('checked', true);
            $('section.section-pj').hide();
            $('section.section-pf').fadeIn('fast');
            $('section.section-pf').find('input').attr('required', true);
            $('section.section-pj').find('input').attr('required', false);
//                $('section.section-pj').find('input').val("");
        }
    }

    function toggleIe(val) {
        if (val == 1) {
            $('input#ie').removeAttr('required');
        } else {
            $('input#ie').attr('required', true);
        }
    }

    $(document).ready(function () {
        $('input[name="type"]').change(function () {
            toggleType($(this).val());
        });
        var type = '{{isset($Data) ? $Data->type : 1}}';
        toggleType(type);
    })


    $(document).ready(function () {
        $('input[name="exemption_ie"]').change(function () {
            toggleIe($('input[name="exemption_ie"]:checked').length > 0);
        });
    });
</script>