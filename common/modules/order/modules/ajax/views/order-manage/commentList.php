<div class="col-md-12">
    <table class="table table-bordered table-condensed">
        <?php foreach ($commentsList as $obj) : ?>
            <tr class="<?= $obj->manually ? 'text-danger' : ''; ?>">
                <td class="col-md-3 commentTime"><?= date('d.m.Y H:i', strtotime($obj->date_create)); ?></td>
                <td class="col-md-3"><?= $obj->user->email; ?></td>
                <td class="col-md-6"><?= $obj->comment->text; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>