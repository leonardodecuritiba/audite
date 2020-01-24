
{!! Html::script('bower_components/jquery-mask-plugin/dist/jquery.mask.min.js') !!}
{!! Html::script('bower_components/jquery-maskmoney/dist/jquery.maskMoney.min.js') !!}
<script type="text/javascript">
    function initMaskMoneyValorReal(selector) {
        $(selector).maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskMoneyValorRealFixado(selector) {
        $(selector).maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: true
        });
    }
    function initMaskInt(selector) {
        $(selector).mask('#', {reverse: true});
    }
    function initMaskFloat(selector) {
        $(selector).mask('#.##0,00', {
            reverse: true
        });
    }
    function initMaskWeight(selector) {
        $(selector).maskMoney({
            suffix: ' kg',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskLength(selector) {
        $(selector).maskMoney({
            suffix: ' m³',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskSize(selector) {
        $(selector).maskMoney({
            suffix: ' cm',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskPercent(selector) {
        $(selector).maskMoney({
            suffix: ' %',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskPercent3(selector) {
        $(selector).maskMoney({
            suffix: ' %',
            precision: 3,
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    $(document).ready(function () {
        initMaskMoneyValorReal($(".show-price"));

        initMaskMoneyValorRealFixado($(".show-fixed-price"));

        initMaskInt($(".show-int"));

        initMaskSize($(".show-size"));

        initMaskWeight($(".show-weight"));

        initMaskLength($(".show-length"));

        initMaskPercent($(".show-percent"));

        initMaskPercent3($(".show-percent3"));
    });
</script>
