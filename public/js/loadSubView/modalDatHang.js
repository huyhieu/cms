/**
 * Created by Hoang Dai on 07/04/2017.
 */

var modal_view=$('.modal-chucnangkhac');
var modal_body=$('.noidung_modal_chucnang');
var url_loadDatHang='';
var token='';

function hienthiDathang(){
    $.post(url_loadDatHang,{
        _token:token
    }, function (result) {
        modal_body.html(result);
        modal_view.modal('show');
    })
}