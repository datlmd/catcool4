//decimal_point = '.';//Dấu thập phân system
//thousand_point = ',';//Dấu hàng nghìn system

$(document).on('keyup', 'input[data-type="currency"]', function(e) {
    formatCurrency($(this));
});
$(document).on('blur', 'input[data-type="currency"]', function(e) {
    formatCurrency($(this), "blur");
});
// $("input[data-type='currency']").on({
//     keyup: function() {
//         formatCurrency($(this));
//     },
//     blur: function() {
//         formatCurrency($(this), "blur");
//     }
// });


function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, thousand_point)
}


function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back     in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") { return; }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(decimal_point) >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(decimal_point);

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur" && decimal_place > 0) {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        //input_val = "$" + left_side + decimal_point + right_side;
        input_val = left_side;
        if (decimal_place > 0) {
            input_val = input_val + decimal_point + right_side;
        }

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        //input_val = "$" + input_val;
        input_val = input_val;

        // final formatting
        if (blur === "blur" && decimal_place > 0) {
            input_val += decimal_point + "00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}