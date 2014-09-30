// check all
$(document).on(' change','input[name="check_all"]',function() {
            $('.idRow').prop("checked" , this.checked);
    });

//scroll to top
$(document).ready(function(){

//Check to see if the window is top if not then display button
$(window).scroll(function(){
  if ($(this).scrollTop() > 100) {
    $('.scrollToTop').fadeIn();
  } else {
    $('.scrollToTop').fadeOut();
  }
});

//owl carousel
$(document).ready(function() {
	$("#owl-demo").owlCarousel({
	  autoPlay: 3000,
	  items : 4,
	  itemsDesktop : [1199,3],
	  itemsDesktopSmall : [979,3]
	});
});


$(document).ready(function() {
    $('.carousel').carousel({interval: 4000});
  });

//news ticker
function tick(){
    $('#ticker li:first').slideUp( function () { $(this).appendTo($('#ticker')).slideDown(); });
}
setInterval(function(){ tick () }, 4000);

//Click event to scroll to top
$('.scrollToTop').click(function(){
  $('html, body').animate({scrollTop : 0},800);
  return false;
});

});

$('.smoothscroll').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 800);
    return false;
});


// drop down menu
$(function(){
	if(screen.width >= 992){
		$('ul li.has-submenu').hover(function(){
			$('.mainmenu-submenu ',this).fadeIn();
			$(this).addClass('mainmenu-open'); 
		},function(){
			$(this).removeClass('mainmenu-open');
			$('.mainmenu-submenu ' ,this).fadeOut('fast');
		});
	}
});

//tooltip
$('.tooltip-demo').tooltip({
    selector: "[data-toggle=tooltip]",
    container: "body"
})

// membuka halaman  tab daftar atau login
$(function(){
	var hash= window.location.hash;
	hash &&$('ul.nav a[href="' + hash + '"]').tab('show')
})

//select no default
$('#select').prop('selectedIndex', -1)

//modal publish
$('.publish').on('click',function(){
	$('#modalpublish').modal({
		show: true,
	})
	
	var myvalue = this.value;
	
	$('#publishid').attr('value',myvalue);
});

//modal unpublish
$('.unpublish').on('click',function(){
	$('#modalunpublish').modal({
		show: true,
	})
	
	var myvalue = this.value;
	
	$('#unpublishid').attr('value',myvalue);
});

//modal 1
$('.modal1').on('click',function(){
	$('#modal1show').modal({
		show: true,
	})
	
	var myvalue = this.name;
	$('#modal1id').attr('value',myvalue);
});

//modal 2
$('.modal2').on('click',function(){
	$('#modal2show').modal({
		show: true,
	})
	
	var myvalue = this.name;
	$('#modal2id').attr('value',myvalue);
});

//modal 3
$('.modal3').on('click',function(){
	$('#modal3show').modal({
		show: true,
	})
	
	var myvalue = this.name;
	var myvalue2 = this.name;
	$('#modal3id').attr('value',myvalue);
	$('#modal3id2').attr('value',myvalue2);
});

//modal 4
$('.modal4').on('click',function(){
	$('#modal4show').modal({
		show: true,
	})
	
	var myvalue = this.name;
	$('#modal4id').attr('value',myvalue);
});

//modal photo
$('.modalphotos img').on('click',function(){
	$('#modalphotoshow').modal({
		show: true,
	})

	var myscr = this.src;
	$('#modalimage').attr('src',myscr);
	$('#modalimage').on('click',function(){
		$('#modalphotoshow').modal('hide')
	})
})

//centering modal
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height() - $dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

$('.modal').on('show.bs.modal', centerModal);
$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});

// input hanya angka
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}    

//preview gambar upload
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('#tampilgambar').attr('src', e.target.result);
       }
        reader.readAsDataURL(input.files[0]);
       }
}

//munculkan dan hilangkan objek
function changeFunc($i) {
    if($i == "tambah"){
		document.getElementById('pilihan').style.display='inline';
	}else{
		document.getElementById('pilihan').style.display='none';
	}
}

$("#tampilinputgambar").change(function() {
    if(this.checked) {
        document.getElementById('inputgambar').style.display='inline';
		document.getElementById('gambartext').value ='Iya, gambar akan muncul di list artikel dan view artikel';
    }else{
    	document.getElementById('inputgambar').style.display='none';
		document.getElementById('gambartext').value ='Tidak';
    }
});

$("#artikelpilihan").change(function() {
    if(this.checked) {
		document.getElementById('artikeltext').value ='Iya, artikel akan muncul di slideshow';
    }else{
		document.getElementById('artikeltext').value ='Tidak';
    }
});

//ongkos kirim
function ongkir($i){
	var id = $i;
	var berat =$('#berat').val();
	var total = $('#total').val();
	var poin = $('#poin').val();

	$.post('includes/tampil_ongkir.php',{postid:id},
	function(data){
		$('#hasil').attr('value',data);  
		var kalkulasi =  (Math.round(data) *  Math.round(berat)) + Math.round(total) - Math.round(poin);
		$('#total_bayar').attr('value',kalkulasi);
	});
}

//validasi check out
function validasi_check_out(){
	var total = $('#total_bayar').val();
	if(total == 0){
		alert("Anda harus memilih tipe pengiriman yang valid di bagian ongkos kirim");
  		return false;
	}
}

//validasi email
function validasi_email()
{
	var x=document.forms["myForm"]["email_pelanggan"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  	{
  	alert("e-mail yang anda masukkan tidak benar, silahkan di periksa lagi");
  	return false;
  	}
}

function validasi_email_komentar()
{
	var x=document.forms["myForm"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  	{
  	alert("e-mail yang anda masukkan tidak benar, silahkan di periksa lagi");
  	return false;
  	}
}

function validasi_email_perusahaan()
{
	var x=document.forms["myForm"]["alamat_email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  	{
  	alert("e-mail yang anda masukkan tidak benar, silahkan di periksa lagi");
  	return false;
  	}
}

// hak akses button
jQuery(function () {
    var $checks = $('input.access');
    $('input[type="radio"][data-access-type]').change(function () {
        var type = $(this).data('accessType');
        $checks.filter('[data-access-' + type + ']').prop('checked', true)
        $checks.not('[data-access-' + type + ']').prop('checked', false)
    })
})


//date time picker
$(function() {
    $( "#datepicker" ).datepicker();
  });
  
 //currency
document.getElementById("number").onblur =function (){    
    this.value = parseFloat(this.value.replace(/,/g, ""))
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

//tab activate
var hash = window.location.hash;
hash && $('ul.nav a[href="' + hash + '"]').tab('show');