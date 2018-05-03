$(document).ready(function () {

  function setPriceInfo() {
    var productId = $('#select_product_id').val();
    var qty = $('#number_item_qty').val();
    var discount = $('#number_discount').val();
    var url = BASE_URL+"/admin/po-product-price?product_id="+productId+"&qty="+qty+"&discount="+discount;
    $.getJSON(url, function (data) {
      $('#item_unit_price').val(data.unit_price);
      $('#item_sub_total').val(data.sub_total);
    });
  }

  $('#select_product_id').change(function () {
    setPriceInfo();
  });
  $('#number_item_qty').change(function () {
    setPriceInfo();
  });
  $('#number_discount').change(function () {
    setPriceInfo();
  });
});

