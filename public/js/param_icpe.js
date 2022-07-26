$(document).ready(function(){
  // Edit icpe max
    $(document).on('click','#edit-icpe-max',function(e){
        e.preventDefault();
        const id = $(this).data('id');
        $('input[name=icpe_max_id]').val(id);
        $('input[name=icpe_max_action]').val('edit');
        $('#ipce_max_title').text('Edition de Valeur Maximal de l\'Icpe');
        $.ajax({
            url:'../pages/action_param_icpe.php',
            method:'POST',
            data:{action:'fetchIcpec',icpe_max_id:id},
            dataType:"json",
            success:function(data)
            {
              console.log('data',data);
              $('#Icpe').val(data.Code_Icpe);
              $('#Regime').val(data.Id_Regime);
              $('#Max').val(data.Max);
              $('#Unite').val(data.Id_Unite);
              $("#icpe_max").modal('show');
              $('#message_operation').html('');
            },
            error: function() {
                console.log("Error:");
            }
          });
    })
    
    //Delete icpe max
    $('.delete_icpe_max').on('click', function(e){
      e.preventDefault();
      // alert('hey ny')
      const icpe_max_id = $(this).data('id');
      $('#icpe_max_id_delete').val(icpe_max_id);
      $('#delete_icpe_max').modal('show');
    });

    //Delete categorie
    $('.delete_categorie_pers').on('click', function(e){
      e.preventDefault();
      // alert('hey ny')
      const icpe_cate_pers_id = $(this).data('id');
      console.log(icpe_cate_pers_id)
      $('#cat_pers_id_delete').val(icpe_cate_pers_id);
      $('#delete_categorie_pers').modal('show');
    });

    // Edit icpe max
    $(document).on('click','#edit-cat-pers',function(e){
      e.preventDefault();
      const categorie_code = $(this).data('id');
      // const batiment_id = $("#batiment_id").val();
      $('input[name=hidden_categie_id]').val(categorie_code);
      $('input[name=categorie_action]').val('edit');
      $('#cat_pers_title').text('Edition de Categorie');
      $.ajax({
          url:'../pages/action_param_icpe.php',
          method:'POST',
          data:{action:'fetchCategorie',categorie_code:categorie_code},
          dataType:"json",
          success:function(data)
          {
            console.log('data',data);
            $('#hidden_categie_id').val(data.Code_categorie);
            $('#code_categorie').val(data.Code_categorie);
            $('#libelle_categorie').val(data.Libelle);
            $("#modal_pers_categorie").modal('show');
            $('#message_operation').html('');
          },
          error: function() {
              console.log("Error:");
          }
        });
  })
})
