<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Script with Style and Script</title>
    <style>
        .ob {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-top: 10px;
        }

        .ob li {
            width: 49%;
            margin: 0 10px 10px 0;
            float: left;
        }

        .ob li .btn {
            width: 100%;
        }

        .ob li:nth-child(2n+2) {
            margin-right: 0;
        }
    </style>
</head>
<body>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
                </button>
                <h4 class="modal-title" id="payModalLabel">
                    <?= lang('suspended_sales') ?>
                </h4>
            </div>
            <div class="modal-body" style="padding-bottom:0;">
                <?= $r ? $this->lang->line('click_to_add') : ''; ?>
                <div class="html_con"><?= $html ?></div>
                <div class="clearfix"></div>
            </div>
            <?php if ($page) { ?>
                <div class="modal-footer" style="padding:0;">
                    <center>
                        <div class="page_con"><?= $page ?></div>
                    </center>
                </div>
            <?php } ?>
        </div>
    </div>
    <script type="text/javascript">
        $('.sus_sale').on('click', function (e) {
            var sid = $(this).attr("id");
            if (count > 1) {
                bootbox.confirm("<?= $this->lang->line('leave_alert') ?>", function (gotit) {
                    if (gotit == false) {
                        return true;
                    } else {
                        window.location.href = "<?= site_url('pos/index') ?>/" + sid;
                    }
                });
            } else {
                window.location.href = "<?= site_url('pos/index') ?>/" + sid;
            }
            return false;
        });
        $('.pagination').on('click', 'a', function (e) {
            e.preventDefault();
            var pg = $(this).attr("href");
            $.get(pg, function (data) {
                $('#myModal').find('.modal-dialog').html(data);
            });
            return false;
        });
    </script>

</body>
</html>