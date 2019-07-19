<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrages'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Groupes'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Modifier un groupe'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulaire de modification d'un groupe</small></h5>
                </div>
                <div class="ibox-content">
                    <form action="<?php echo url_for('sfGuardGroup/modifier/?id=' . $form->getObject()->getId()) ?>" id="formModifierG" class="form-horizontal" method="POST">
                        <?php
                        echo $form['_csrf_token'];
                        echo $form['id'];
                        ?>

                        <div class="form-group"><label class="col-sm-2 control-label">Nom du groupe</label>
                            <div class="col-sm-10"><?php echo $form['name']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10"><?php echo $form['description']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Permissions</label>
                            <div class="col-sm-10"><?php echo $form['permissions_list']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Widgets</label>
                            <div class="col-sm-10"><?php echo $form['widget_list']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" onclick="goBack();" type="button">Annuler</button>
                                <button class="btn btn-primary" onclick="controlModifGroupe();" type="button">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var erreurGroupe = false;
    var erreurDescription = false;

    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltEdtHrchy').html());

        var nom = $('#sf_guard_group_name').val();
        var id = $('#sf_guard_group_id').val();

        if ($('#sf_guard_group_name').val() != "")
            setHasSuccess('#sf_guard_group_name');
        if ($('#sf_guard_group_description').val() != "")
            setHasSuccess('#sf_guard_group_description');

        $('#sf_guard_group_name').keypress(function (e) {
            if (e.which == 13)
                return false;
        });

        $("#sf_guard_group_name").focusout(function () {
            if ($("#sf_guard_group_name").val() != "") {
                if (controlNomGroupeG(nom, idGroupe)) {
                    erreurGroupe = false;
                    setHasSuccess("#sf_guard_group_name");
                }
            } else {
                setHasError("#sf_guard_group_name");
                erreurGroupe = true;
            }
        });

        $("#sf_guard_group_description").focusout(function () {
            if ($("#sf_guard_group_description").val() != "") {
                setHasSuccess("#sf_guard_group_description");
                erreurDescription = false;
            } else {
                setHasError("#sf_guard_group_description");
                erreurDescription = true;
            }
        });
    });// fin ready

    function controlNomGroupeG(nom, id) {
        var retour;

        $.ajaxSetup({async: false});

        $.post("<?php echo url_for('controlNomGroupe') ?>", {'name': nom, 'id': id},
        function (data)
        {
            if (data == "") {
                setHasSuccess("#sf_guard_group_name");
                retour = true;
            }
            else {
                setHasError("#sf_guard_group_name");
                retour = false;
            }
        });
        return retour;
    }

    function controlModifGroupe() {
        var erreur = false;
        if ($('#sf_guard_group_name').val() == "") {
            setHasError("#sf_guard_group_name");
            erreur = true;
        }
        if ($('#sf_guard_group_description').val() == "") {
            setHasError("#sf_guard_group_description");
            erreur = true;
        }
        if (erreurGroupe) {
            erreur = true;
        }
        if (erreurDescription) {
            erreur = true;
        }
        if (!erreur) {
            if (controlNomGroupeG($('#sf_guard_group_name').val(), $('#sf_guard_group_id').val())) {
                $('#sf_guard_group_permissions_list option').prop('selected', 'selected');
                $('#sf_guard_group_widget_list option').prop('selected', 'selected');

                $('#formModifierG').submit();
            }
        }
    }

    function controleNomGroupeTip() {
        $('#sf_guard_group_name').qtip({
            position: {
                corner: {
                    target: 'topRight',
                    tooltip: 'bottomLeft'
                }
            },
            content: 'Ce nom de groupe existe déjà !',
            show: {
                ready: true,
                when: {event: false}
            },
            hide: {when: {event: 'click'}},
            style: {
                name: 'dark',
                tip: true
            }
        });
    }

</script>