<?php
function plural_form($number, $after) {
    $cases = array (2, 0, 1, 1, 1, 2);
    echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}
function sort_ar($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

$json = file_get_contents("data.json");
$result = json_decode($json, true);
?>
<html>
    <head>
        <title>Test for SkyNet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="nav_bar">
            <div class="wrapper">
                <a href="javascript:void(0)" class="back"></a>
                <span class="title"></span>
            </div>
        </div>
        <div id="screen_1">
            <?foreach ($result['tarifs'] as $groupID=>$group){
                $min_price = 0;
                $max_price = 0;
                usort($group['tarifs'],'sort_ar');?>
                <div class="content_for_screen_2" data-group-id="<?=$groupID?>">
                <?foreach ($group['tarifs'] as $tarifKey=>$tarif){
                    $min_price == 0 ? $min_price = $tarif['price'] : ($min_price > $tarif['price'] ? $min_price = $tarif['price'] : $min_price );
                    $max_price == 0 ? $max_price = $tarif['price'] : ($max_price < $tarif['price'] ? $max_price = $tarif['price'] : $max_price );?>
                        <div class="tarif">
                            <h2><?=plural_form($tarif['pay_period'],['месяц','месяца','месяцев'])?></h2>
                            <hr/>
                            <a href="javascript:void(0)" class="tarif_link" data-tarif-id="<?=$tarif['ID']?>">
                                <span class="price"><?=(int)$tarif['price'] / (int)$tarif['pay_period']?> ₽/мес</span>
                                <span class="description">разовый платеж — <?=$tarif['price']?> ₽</span>
                                <?if ($tarif['pay_period'] != 1){?>
                                    <span class="description">скидка — <?= (int)$result['tarifs'][0]['tarifs'][0]['price'] * (int)$tarif['pay_period'] - (int)$tarif['price'] / (int)$tarif['pay_period'] ?> ₽</span>
                                <?}?>
                            </a>
                        </div>
                    <div class="content_for_screen_3" data-tarif-id="<?=$tarif['ID']?>">
                        <div class="tarif">
                            <h2>Тариф "<?=$tarif['title']?>"</h2>
                            <hr/>
                            <b>Период оплаты — <?=plural_form($tarif['pay_period'],['месяц','месяца','месяцев'])?></b>
                            <b><?=(int)$tarif['price'] / (int)$tarif['pay_period']?> ₽/мес</b>
                            <br/>
                            <span>разовый платёж — <?=$tarif['price']?> ₽</span>
                            <span>со счёта спишется — <?=$tarif['price']?> ₽</span>
                            <br/>
                            <span class="gray">вступит в силу — сегодня</span>
                            <span class="gray">активно до — <?=date("d.m.Y",mktime(0,0,0,date("m") + (int)$tarif['pay_period'],date("d"),date("Y")))?></span>
                            <hr/>
                            <a href="javascript:void(0)" class="button">Выбрать</a>
                        </div>
                    </div>
                <?}?>
                </div>
                <div class="tarif">
                    <h2>Тариф "<?=$group['title']?>"</h2>
                    <hr/>
                    <a href="javascript:void(0)" class="tarif_link" data-group-id="<?=$groupID?>">
                        <span class="speed <?=$group['speed'] == '50' ? "brown" : ( $group['speed'] == '100' ? "blue" : "red" ) ?>"><?=$group['speed']?> Мбит/с</span>
                        <span class="price"><?=$min_price?> – <?=$max_price?> ₽/мес</span>
                        <?if (!empty($group['free_options'])) {
                            foreach ($group['free_options'] as $option) {?>
                                <span class="description"><?= $option ?></span>
                            <?}
                        }?>
                    </a>
                    <hr/>
                    <a href="<?=$group['link']?>" class="more">узнать подробнее на сайте www.sknt.ru</a>
                </div>
            <?}?>
        </div>
        <div id="screen_2">

        </div>
        <div id="screen_3">

        </div>
        <script src="common.js"></script>
    </body>
</html>
