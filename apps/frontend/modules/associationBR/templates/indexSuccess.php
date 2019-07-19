<?php
//Slot du titre de la page
slot('page_title', sprintf('Association produit/BR'));
?>
<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li class="active">
                <strong><?php echo __('Numéro d’Arrivage/BR'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Ajouter une association :') ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="formAjout" class='form-horizontal'> 
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <?php echo __('N° arrivage') ?>
                                        </label>
                                        <div class="col-sm-9">
                                            <input id="produit" name="produit" class="form-control" value=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <?php echo __('N° reception') ?>
                                        </label>
                                        <div class="col-sm-9">
                                            <input id="brsap" name="brsap" class="form-control" value=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-offset-1 col-xs-6 col-xs-offset-5">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit"><?php echo __('Ajouter'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rowTable">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Association produit/Br'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick=" showAddAsso(); //showForm('<?php echo url_for(array('sf_route' => 'referentiels-transporteur-new')) ?>');"><?php echo __('Ajouter/modifier') ?></a>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php include_partial('list', array('assBR' => $assBR)) ?> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var table = null;
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());

        table = $('.dataTables').DataTable({
            pageLength: 100,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
            }
        });

        $('#formAjout').submit(function (e) {
            e.preventDefault();
            validerAss();
        });
        $('#produit').focus();

    });
    function reloadList() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'association-br-list-ajax')) ?>'
        }).done(function (data) {
            table.destroy();
            $('#list-ajax-div .rowTable .ibox-content').empty();
            $('#list-ajax-div .rowTable .ibox-content').append(data);
            table = $('#list-ajax-div .rowTable .ibox-content .dataTables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }

    function validerAss() {
        removeAllSet('#produit');
        removeAllSet('#brsap');
        if ($('#produit').val() != "") {
            if ($('#brsap').val() != "") {
                $.post("<?php echo url_for('association-br-validerAss') ?>", {'prod': $('#produit').val(), 'sap': $('#brsap').val()}, function (data) {
                    var temp = data.split('+');
                    if (temp[0] > 0) {
                        if (temp[1] > 0) {
                            setHasError('#brsap');
                            $('#brsap').select();
                        } else {
                            reloadList();
                            setHasSuccess('#produit');
                            setHasSuccess('#brsap');
                            $('#produit').val('');
                            $('#brsap').val('');
                            $('#produit').select();
                        }

                    } else {
                        setHasError('#produit');
                        $('#produit').select();
                    }
                });
            } else {
                setHasError('#brsap');
                $('#brsap').select();
            }
        } else {
            setHasError('#produit');
            $('#produit').select();
        }
    }

</script>