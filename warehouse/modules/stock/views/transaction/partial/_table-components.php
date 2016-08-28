<?php $modelsProductComponent = $this->context->model->modelsProductComponent; ?>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th class="col-md-5">ID комплектующей</th>
        <th class="col-md-5">Название комплектующей</th>
        <th class="col-md-5 text-center">Кол-во</th>
    </tr>
    </thead>

    <tbody class="container-product-components">
    <?php foreach ($modelsProductComponent as $index => $modelComponent): ?>
        <tr class="product-component-item">
            <td class="vcenter">
                <?= $modelComponent->productComponent->id; ?>
            </td>
            <td class="vcenter">
                <?= $modelComponent->productComponent->name; ?>
            </td>
            <td class="vcenter">
                <?= $modelComponent->quantity; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>