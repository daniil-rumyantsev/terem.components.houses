<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$cnt = 1;
?>

<?php foreach ($arResult["categories"] as $key => $cat): ?>
<!--one item-->
<div class="row">
    <div class="col-xs-12 col-md-12 col-sm-12">
        <div class="( my-collapse-btn + design-bordered ) collapsed" type="button" data-toggle="collapse" data-target="#price<?=$cnt?>" aria-expanded="false" aria-controls="price<?=$cnt?>">
            <div class="my-table">
                <div>
                    <p><?php echo $cat["NAME"]; ?></p>
                </div>
                <div>
                    <i class="glyphicon glyphicon-chevron-up"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-sm-12">
        <div class="collapse my-collapse" id="price<?=$cnt?>">
            <div class="( my-collapse-content + design-bordered-none )">
	            <table class="table table-striped table-prices">
	                <thead>
	                    <tr>
	                        <th></th>
	                        <th>
	                            <p>Лето</p>
	                        </th>
							  <th>
	                            <p>Зима</p>
	                        </th>
	                        <th>
	                            <p>Постоянное проживание</p>
	                        </th>
	                    </tr>
	                    </thead>
	                <tbody>
	                <?php foreach($cat["HOUSES"] as $v): ?>
	                    <?php if(count($v['KARKAS']) > 0) :?>
                        <tr>
                            <td>
                                <p>
                                    <a href="<?=$v['LINK']?>"><?=$v['NAME']?> Каркас <?=$v['PROPERTY_SIZER_VALUE']?> м</a>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KARKAS']["LETO"]):?>
                                    <?=number_format($v['KARKAS']["LETO"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KARKAS']["ZIMA"]):?>
                                    <?=number_format($v['KARKAS']["ZIMA"], 0, ' ', ' ');?>
                                <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KARKAS']["POST"]):?>
                                    <?=number_format($v['KARKAS']["POST"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                        </tr>
	                    <?php endif;?>
	                    <?php if(count($v['BRUS']) > 0) :?>
                        <tr>
                            <td>
                                <p>
                                    <a href="<?=$v['LINK']?>"><?=$v['NAME']?> Брус <?=$v['PROPERTY_SIZER_VALUE']?> м</a>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['BRUS']["LETO"]):?>
                                        <?=number_format($v['BRUS']["LETO"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['BRUS']["ZIMA"]):?>
                                        <?=number_format($v['BRUS']["ZIMA"], 0, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['BRUS']["POST"]):?>
                                        <?=number_format($v['BRUS']["POST"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                        </tr>
	                    <?php endif;?>
	                    <?php if(count($v['KIRP']) > 0) :?>
                        <tr>
                            <td>
                                <p>
                                    <a href="<?=$v['LINK']?>"><?=$v['NAME']?> Кирпичный <?=$v['PROPERTY_SIZER_VALUE']?> м</a>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KIRP']["LETO"]):?>
                                        <?=number_format($v['KIRP']["LETO"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KIRP']["ZIMA"]):?>
                                        <?=number_format($v['KIRP']["ZIMA"], 0, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php if($v['KIRP']["POST"]):?>
                                        <?=number_format($v['KIRP']["POST"], 3, ' ', ' ');?>
                                    <?php endif;?>
                                </p>
                            </td>

                        </tr>
	                    <?php endif;?>
	                <?php endforeach; ?>
	                </tbody>
	                <tfoot>
	                    <tr>
	                        <td colspan="5">
	                            <button type="button" data-toggle="collapse" data-target="#price<?=$cnt?>" aria-expanded="false" aria-controls="price<?=$cnt?>">свернуть</button>
	                        </td>
	                    </tr>
	                </tfoot>
	            </table>    
            </div>
        </div>
    </div>
</div>
<!--one item END-->
<? $cnt++; ?>
<?php endforeach; ?> 