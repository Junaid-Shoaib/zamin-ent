<div class="mb-3">
    <label>Customer *</label>
    <select name="customer_id" class="form-control" required>
        <option value="">  Select Customer </option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}" data-reg_type="{{ $customer->registration_type }}" {{ old('customer_id', $invoice->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }} - {{ $customer->address }}
            </option>
        @endforeach
    </select>
</div>

    <select name="registration_type" class="form-control" required hidden>
       <option value="Registered" {{ old('registration_type', $invoice->registration_type ?? '') == 'Registered' ? 'selected' : '' }}>Registered</option>
        <option value="Unregistered" {{ old('registration_type', $invoice->registration_type ?? '') == 'Unregistered' ? 'selected' : '' }}>Unregistered</option>
    </select>

<div class="mb-3">
    <label>Reference Number *</label>
    <input type="text" name="reference_no" class="form-control" 
        value="{{ old('reference_no', $invoice->reference_no ?? '') }}" required>
</div>   

<div class="mb-3">
    <label>Date of Supply *</label>
    <input type="date" name="date_of_supply" class="form-control" 
        value="{{ old('date_of_supply', $invoice->date_of_supply ?? now()->format('Y-m-d')) }}" required>
</div>        

<div class="mb-3">
    <label>Time of Supply *</label>
    <input type="time" name="time_of_supply" class="form-control" 
        value="{{ old('time_of_supply', $invoice->time_of_supply ?? now()->format('H:i')) }}" required>
</div>        
<style>
    .table {
    table-layout: auto;
    width: 100%;
    white-space: nowrap;
}

/* Specific column widths */
.col-hscode   { min-width: 120px; text-align: center; }
.col-name     { min-width: 200px; }
.col-desc     { min-width: 250px; }
.col-uom      { min-width: 80px; text-align: center; }
.col-num      { min-width: 110px; text-align: center; }

/* Make header sticky (optional for UX) */
thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 2;
}


</style>
<h5 class="mt-4 mb-2">Invoice Items</h5>
<div id="items-table-wrapper" style="overflow-x: auto; width: 100%;">

    <table class="table table-bordered table-striped table-sm align-middle" id="items-table" style="min-width: 1200px; width: auto;">
        <thead class="table-light text-center">
            <tr>
                
                <th class="col-hscode">H.S.Code</th>
                <th class="col-name">Product Name</th>
                <th class="col-desc">Description</th>
                <th class="col-uom">UOM</th>
                <th class="col-num">Unit Price</th>
                <th class="col-num">Qty</th>
                <th class="col-num">Rate</th>
                <th class="col-num">ST %</th>
                <th class="col-num">ST Amount</th>
                <th class="col-num">ST withheld as WH</th>
                <th class="col-num">Extra Tax</th>
                <th class="col-num">Further Tax</th>
                <th class="col-num">Total</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success" id="add-row">
                        <i class="fas fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @if(old('items') || isset($invoice))
                @php
                    $itemRows = old('items', isset($invoice) ? $invoice->items->toArray() : []);
                @endphp
                @foreach($itemRows as $i => $row)
                <tr>
                    <td><input type="text" name="items[{{ $i }}][hs_code]" class="form-control" value="{{ $row['hs_code'] ?? '' }}"></td>
                    <td><input type="text" name="items[{{ $i }}][product_name]" class="form-control" value="{{ $row['product_name'] ?? ($row['item']['name'] ?? '') }}"></td>
                    <td><input type="text" name="items[{{ $i }}][description]" class="form-control" value="{{ $row['description'] ?? '' }}"></td>
                    <td><input type="text" name="items[{{ $i }}][uom]" class="form-control" value="{{ $row['uom'] ?? '' }}"></td>

                    <td><input type="text" step="0.01" name="items[{{ $i }}][unit_price]" class="form-control numeric-only unit-price" value="{{ $row['unit_price'] ?? '' }}" required></td>
                    <td><input type="text" name="items[{{ $i }}][quantity]" class="form-control numeric-only quantity" value="{{ $row['quantity'] ?? 1 }}" min="1" required></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][value_of_goods]" class="form-control numeric-only value" value="{{ $row['value_of_goods'] ?? '' }}" readonly></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][sale_tax_rate]" class="form-control numeric-only st-rate" value="{{ $row['sale_tax_rate'] ?? 18 }}"></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][amount_of_saleTax]" class="form-control numeric-only st-amount" value="{{ $row['amount_of_saleTax'] ?? '' }}" readonly></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][sale_tax_withheld]" class="form-control numeric-only stw" value="{{ $row['sale_tax_withheld'] ?? 0 }}"></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][extra_tax]" class="form-control numeric-only et" value="{{ $row['extra_tax'] ?? 0 }}"></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][further_tax]" class="form-control numeric-only ft" value="{{ $row['further_tax'] ?? 0 }}"></td>
                    <td><input type="text" step="0.01" name="items[{{ $i }}][total]" class="form-control numeric-only total" value="{{ $row['total'] ?? '' }}" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
                @endforeach
            @else
            <tr>
                <td><input type="text" name="items[0][hs_code]" class="form-control"></td>
                <td><input type="text" name="items[0][product_name]" class="form-control"></td>
                <td><input type="text" name="items[0][description]" class="form-control"></td>
                <td><input type="text" name="items[0][uom]" class="form-control"></td>

                <td><input type="text" step="0.01" name="items[0][unit_price]" class="form-control numeric-only unit-price" required></td>
                <td><input type="text" name="items[0][quantity]" class="form-control numeric-only quantity" value="1" min="1" required></td>
                <td><input type="text" step="0.01" name="items[0][value_of_goods]" class="form-control numeric-only value" readonly></td>
                <td><input type="text" step="0.01" name="items[0][sale_tax_rate]" class="form-control numeric-only st-rate" value="18"></td>
                <td><input type="text" step="0.01" name="items[0][amount_of_saleTax]" class="form-control numeric-only st-amount" readonly></td>
                <td><input type="text" step="0.01" name="items[0][sale_tax_withheld]" class="form-control numeric-only stw" value="0"></td>
                <td><input type="text" step="0.01" name="items[0][extra_tax]" class="form-control numeric-only et" value="0"></td>
                <td><input type="text" step="0.01" name="items[0][further_tax]" class="form-control numeric-only ft" value="0"></td>
                <td><input type="text" step="0.01" name="items[0][total]" class="form-control numeric-only total" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@push('scripts')
<script>
let rowIndex = {{ isset($invoice) ? ($invoice->items->count() ?? 0) : 1 }};

$('select[name="customer_id"]').on('change', function () {
    const regType = $(this).find(':selected').data('reg_type');
    if (regType) {
        $('select[name="registration_type"]').val(regType).trigger('change');
    }
});


// function calculateRow(row) {
//     const price = row.find('.unit-price').val() || 0;
//     const qty   = parseInt(row.find('.quantity').val()) || 1;
//     const rate  = row.find('.st-rate').val() || 18;
//     const et    = row.find('.et').val() || 0;
//     const stw   = row.find('.stw').val() || 0;

//     var ft = row.find('.ft').val() || 0;

//     const value = price * qty;
//     const tax   = value * rate / 100;

//     // 🔥 Registration type check
//     const regType = $('select[name="registration_type"]').val();
//     if (regType === "Unregistered") {
//         ft = value * 0.04; // 4% of value_of_goods
//         row.find('.ft').val(ft.toFixed(2));
//     }

//     const total = value + tax + et + stw + ft;

//     row.find('.value').val(value.toFixed(5));
//     row.find('.st-amount').val(tax.toFixed(5));
//     row.find('.total').val(total.toFixed(5));
// }


function calculateRow(row) {
    const price = parseFloat(row.find('.unit-price').val()) || 0;
    const qty   = parseFloat(row.find('.quantity').val()) || 1;
    const rate  = parseFloat(row.find('.st-rate').val()) || 18;
    const et    = parseFloat(row.find('.et').val()) || 0;
    const stw   = parseFloat(row.find('.stw').val()) || 0;

    let ft      = parseFloat(row.find('.ft').val()) || 0;

    const value = price * qty;
    const tax   = value * rate / 100;

    // 🔥 Registration type check
    const regType = $('select[name="registration_type"]').val();
    if (regType === "Unregistered") {
        ft = value * 0.04; // 4% of value_of_goods
        row.find('.ft').val(ft.toFixed(2));
    }

    const total = value + tax + et + stw + ft;

    row.find('.value').val(value.toFixed(2));
    row.find('.st-amount').val(tax.toFixed(2));
    row.find('.total').val(total.toFixed(2));
}

$(document).on('input change', '.unit-price, .quantity, .st-rate, .et, .stw, .ft, select[name="registration_type"]', function () {
    $('#items-table tbody tr').each(function () {
        calculateRow($(this));
    });
});

$('#add-row').on('click', function () {
    const newRow = `
        <tr>
            <td><input type="text" name="items[${rowIndex}][hs_code]" class="form-control"></td>
            <td><input type="text" name="items[${rowIndex}][product_name]" class="form-control"></td>
            <td><input type="text" name="items[${rowIndex}][description]" class="form-control"></td>
            <td><input type="text" name="items[${rowIndex}][uom]" class="form-control"></td>

            <td><input type="text" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control numeric-only unit-price" required></td>
            <td><input type="text" name="items[${rowIndex}][quantity]" class="form-control numeric-only quantity" value="1" min="1" required></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][value_of_goods]" class="form-control numeric-only value" readonly></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][sale_tax_rate]" class="form-control numeric-only st-rate" value="18"></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][amount_of_saleTax]" class="form-control numeric-only st-amount" readonly></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][sale_tax_withheld]" class="form-control numeric-only stw" value="0"></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][extra_tax]" class="form-control numeric-only et" value="0"></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][further_tax]" class="form-control numeric-only ft" value="0"></td>
            <td><input type="text" step="0.01" name="items[${rowIndex}][total]" class="form-control numeric-only total" readonly></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
        </tr>`;

    $('#items-table tbody').append(newRow);
    rowIndex++;
});

$(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
});

</script>
<script>
function allowOnlyNumbers(el) {
    el.value = el.value
        .replace(/[^0-9.]/g, '')     // allow only numbers & dot
        .replace(/(\..*)\./g, '$1'); // allow only one dot
}

// attach event to all numeric inputs
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('numeric-only')) {
        allowOnlyNumbers(e.target);
    }
});
</script>

@endpush