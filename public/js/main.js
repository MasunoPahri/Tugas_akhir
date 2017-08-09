var idCollapse = 0;
var kategori = letterSize = jlhPakaian = l_badan = value = l_pinggang = l_pundak = p_lengan = p_blazzer = desc = 0;
$(document).ready(function(){
    $('.collapse').collapse();
    $('.k_special, .k_special2').hide();
    $('#kategori').on('change', function(){
	    var changedOption = $(this).find('option:selected').val();
        console.log(changedOption);

        if(changedOption == "celana keeper" || changedOption == "celana jeans"){
            $('.k_special2').show();
            $('.k_special').hide();
        }
        else{
            $('.k_special').show();
            $('.k_special2').hide();
        }
    });

    $('#addItem').on('click', function(){
        var sizeAttr = formItem = "";
        idCollapse++;
        var pjgCelana = k_pinggang = k_kaki = l_pisak = 0;
        var l_badan = l_pinggang = l_pinggul = l_pundak = p_lengan = p_blazzer = 0;

        sizeMode    = $(this).attr('sizeMode');
        kategori    = $('#kategori').val();
        letterSize  = $('#size').val();
        jlhPakaian  = $('#pcs').val();
        
        pjgCelana   = $('#pjgCelana').val();
        k_pinggang  = $('#k_pinggang').val();
        k_kaki      = $('#k_kaki').val();
        l_pisak     = $('#l_pisak').val();

        l_badan     = $('#l_badan').val();
        l_pinggang  = $('#l_pinggang').val();
        l_pinggul   = $('#l_pinggul').val();
        l_pundak    = $('#l_pundak').val();
        p_lengan    = $('#p_lengan').val();
        p_blazzer   = $('#p_blazzer').val();

        img         = $('#img').prop("files");
        desc        = $('#desc').val();

        if(sizeMode == "customize"){
            if(kategori == "celana keeper" || kategori == "celana jeans"){
                sizeAttr = 
                    "<li>"+
                        "<b>Ukuran </b>"+
                        "<ul>"+
                            "<li>"+
                                "Panjang Celana "+ pjgCelana + "cm" +
                            "</li>"+
                            "<li>"+
                                "Keliling Pinggang "+ k_pinggang + "cm" +
                            "</li>"+
                            "<li>"+
                                "Lingkar Pisak "+ l_pisak + "cm" +
                            "</li>"+
                            "<li>"+
                                "Keliling Kaki "+ k_kaki + "cm" +
                            "</li>"+
                        "</ul>"+
                    "</li>";
            }
            else{
                sizeAttr = 
                    "<li>"+
                        "<b>Ukuran </b>"+
                        "<ul>"+
                            "<li>"+
                                "Lingkar Badan "+ l_badan + "cm" +
                            "</li>"+
                            "<li>"+
                                "Lingkar Pinggang "+ l_pinggang + "cm" +
                            "</li>"+
                            "<li>"+
                                "Lingkar Pinggul "+ l_pinggul + "cm" +
                            "</li>"+
                            "<li>"+
                                "Lingkar Pundak "+ l_pundak + "cm" +
                            "</li>"+
                            "<li>"+
                                "Panjang Lengan "+ p_lengan + "cm" +
                            "</li>"+
                            "<li>"+
                                "Panjang Blazer "+ p_blazzer + "cm" +
                            "</li>"+
                        "</ul>"+
                    "</li>";
            }
            formItem = 
                "<div class='item' id='itemP_"+ idCollapse +"'>"+
                    "<input type='hidden' class='form-control' value='"+kategori+"' name='kategori[]'>"+
                    "<input type='hidden' class='form-control' value='"+pjgCelana+"' name='pjgCelana[]'>"+
                    "<input type='hidden' class='form-control' value='"+k_pinggang+"' name='k_pinggang[]'>"+
                    "<input type='hidden' class='form-control' value='"+l_pisak+"' name='l_pisak[]'>"+
                    "<input type='hidden' class='form-control' value='"+k_kaki+"' name='k_kaki[]'>"+
                    "<input type='hidden' class='form-control' value='"+l_badan+"' name='l_badan[]'>"+
                    "<input type='hidden' class='form-control' value='"+l_pinggang+"' name='l_pinggang[]'>"+
                    "<input type='hidden' class='form-control' value='"+l_pinggul+"' name='l_pinggul[]'>"+
                    "<input type='hidden' class='form-control' value='"+l_pundak+"' name='l_pundak[]'>"+
                    "<input type='hidden' class='form-control' value='"+p_lengan+"' name='p_lengan[]'>"+
                    "<input type='hidden' class='form-control' value='"+p_blazzer+"' name='p_blazzer[]'>"+
                    "<input type='hidden' class='form-control' value='"+desc+"' name='desc[]'>"+
                "</div>";
        }
        else if(sizeMode == "standart"){
            sizeAttr =
                "<li>"+ 
                    "<b>Jumlah dan Ukuran Pakaian </b><br>"+
                    letterSize + ' ' + jlhPakaian + 'pcs'+
                "</li>";
            
            formItem = 
                "<div class='item' id='itemP_"+ idCollapse +"'>"+
                    "<input type='hidden' class='form-control' value='"+kategori+"' name='kategori[]'>"+
                    "<input type='hidden' class='form-control' value='"+letterSize+"' name='letterSize[]'>"+
                    "<input type='hidden' class='form-control' value='"+jlhPakaian+"' name='jlhPakaian[]'>"+
                    "<input type='hidden' class='form-control' value='"+desc+"' name='desc[]'>"+
                "</div>";
        }

        // var images = $.map(img, function(val) { console.log(val); });
        // console.log(images);


        var listItem = 
            "<div class='panel panel-default' id='itemP_"+ idCollapse +"'>"+
                "<div class='panel-heading' role='tab' id='headingOne'>"+
                    "<h4 class='panel-title'>"+
                        "<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse"+ idCollapse + "' aria-expanded='t    rue' aria-controls='collapse"+ idCollapse + "'>"+
                            "Pakaian "+ idCollapse +
                        "</a>"+
                        "<a href='#' class='pull-right dltItem' pid='"+ idCollapse +"'>hapus</a>"+
                    "</h4>"+
                "</div>"+   
                "<div id='collapse"+ idCollapse + "'class='panel-collapse collapse in' role='tabpanel' aria-labelledby='headingOne'>"+
                    "<div class='panel-body'>"+
                        "<ul class='ctnItem'>"+
                            "<li id='cateTitle'>"+
                                "<b>Kategori </b>"+
                                kategori +
                            "</li>"+
                            sizeAttr+    
                            "<li>"+
                                "<b>Deskripsi</b>"+ "<br>"+
                                desc+
                            "</li>"+
                        "</ul>"+
                    "</div>"+
                "</div>"+
            "</div>";

        $('#inItemPakaian')[0].reset()
        $('.itemPakaian').append(formItem);
        $('.itemList').append(listItem);
    });

    
    $('.itemList').on('click', '.dltItem', function(){
        var pid = $(this).attr('pid');
        console.log(pid);
        $('.itemPakaian #itemP_'+pid).remove();
        $(this).closest('div[id^=item]').remove();
    });
});