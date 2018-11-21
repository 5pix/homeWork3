<?php
/** Задание №1
 * Написать скрипт, который выведет всю информацию из этого файла в удобно
читаемом виде. Представьте, что результат вашего скрипта будет распечатан и выдан
курьеру для доставки, разберется ли курьер в этой информации?
*/
function readXmlData($loadXml)
{
    $viewtable = "<table><tbody>";
    $viewtable .= "<tr><td>Закза № - {$loadXml->attributes()->PurchaseOrderNumber}</td>
        <td>Дата заказа - {$loadXml->attributes()->OrderDate}</td></tr>";

    foreach ($loadXml as $shipping) {
        if (!empty($shipping->attributes())) {
            $viewtable .= "<tr><td>Тип доставки: <b> {$shipping->attributes()} </b></td></tr>";
            $viewtable .= "<tr><td>Имя: {$shipping->Name}</td></tr>";
            $viewtable .= "<tr><td>Улица: {$shipping->Street}</td></tr>";
            $viewtable .= "<tr><td>Город: {$shipping->City}</td></tr>";
            $viewtable .= "<tr><td>Регион: {$shipping->State}</td></tr>";
            $viewtable .= "<tr><td>Индекс: {$shipping->Zip}</td></tr>";
            $viewtable .= "<tr><td>Страна: {$shipping->Country}</td></tr>";
        }
    }
        $viewtable .= "<tr><td>Примечания к отправке: {$loadXml->DeliveryNotes}</td></tr>";
        $viewtable .= "<tr><th>Заказанные позиции: </th></tr>";
    
    foreach ($loadXml->Items->Item as $item) {
        $viewtable .= "<tr><td>Товар №1</td></tr>";
        $viewtable .= "<tr><td>Номер: {$item->attributes()->PartNumber}</td></tr>";
        $viewtable .= "<tr><td>Название: {$item->ProductName}</td></tr>";
        $viewtable .= "<tr><td>Количество: {$item->Quantity}</td></tr>";
        $viewtable .= "<tr><td>Цена в \$: {$item->USPrice}</td></tr>";
        if (empty($item->Comment)) {
            $viewtable .= "<tr><td>Комментария нет от пользователя</td></tr>";
        } else {
            $viewtable .= "<tr><td>Комментарий: {$item->Comment}</td></tr>";
        }
    }
    echo $viewtable;
    return;

}

/**Задание #2
 * 1. Создайте массив, в котором имеется как минимум 1 уровень вложенности.
Преобразуйте его в JSON. Сохраните как output.json
2. Откройте файл output.json. Случайным образом, используя функцию rand(), решите
изменять данные или нет. Сохраните как output2.json
3. Откройте оба файла. Найдите разницу и выведите информацию об отличающихся
элементах
 */

$multyarray = ['oneLevel' =>
    ['name' => 'Ivan', 'family' => 'Chudnov',
        'name' => 'Fedor', 'family' => 'Veselov'],
    'secondLevel' =>
        ['name' => 'Svetlana', 'family' => 'Svetlaya']
];

function task2($inputArray)
{
    $jsonString = json_encode($inputArray);
        echo 'пишем данные в файл ....<br/>';
    if (!empty($jsonString)) {
        file_put_contents("output.json", $jsonString);
        echo 'данные успешно записаны в файл<br>';
    } else {
        echo "передан пустой массив";
    }
    $randNum = rand(1, 2);
    if ($randNum === 1) {
            $getData = json_decode(file_get_contents('output.json'), true);
            $getData = ['name' => 'Sergey', 'family' =>'Esenin', 'one', 'two'];
            file_put_contents("output2.json", json_encode($getData));
            echo 'данные изменены';
        // сравниваем два массива
        $firstJsonData = json_decode(file_get_contents('output.json'), true);
        $secondJsonData = json_decode(file_get_contents('output2.json'), true);
            $resOne = array_diff($firstJsonData, $secondJsonData);
            $resTwo = array_diff($secondJsonData, $firstJsonData);
            echo "<pre>";
            var_dump($resOne);
            echo "</pre><<pre>";
            var_dump($resTwo);
            echo "</pre>";
    } else {
        $noGetData = json_decode(file_get_contents('output.json'), true);
        echo 'данные не были изменены, оба файла одинаковые';
        $firstJsonData = json_decode(file_get_contents('output.json'), true);
        $secondJsonData = json_decode(file_get_contents('output2.json'), true);
        $resOne = array_diff($firstJsonData, $secondJsonData);
        $resTwo = array_diff($secondJsonData, $firstJsonData);
        echo "<pre>";
        var_dump($resOne);
        echo "</pre><pre>";
        var_dump($resTwo);
        echo "</pre>";
    }

    echo "<hr>";
    return;
}
/** Задание #3
 * Программно создайте массив, в котором перечислено не менее 50 случайных чисел
от 1 до 100
2. Сохраните данные в файл csv
3. Откройте файл csv и посчитайте сумму четных чисел
*/
function task3()
{
    for ($i = 0; $i < 25; $i++) {
        $randNumber[$i] = rand(1, 25);
    }
    $randNumberArray[] = $randNumber;
    $fp = fopen('task3.csv', 'w');
    foreach ($randNumberArray as $fields) {
        fputcsv($fp, $fields);

    }
    $row = 1;
    $res = 0;
    if (($handle = fopen("task3.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $num = count($data);
            echo "<p> {$num} полей в строке {$row}: <br /></p>";
            $row++;
            for ($j = 0; $j < $num; $j++) {
                if ($data[$j] % 2 == 0) {
                    $res = $res + $data[$j];
                }

            }
            echo "Сумма четных чисел = {$res}</br>";
        }
    }
    echo "<hr>";
}
/** Задача №4
 *1. С помощью PHP запросить данные по адресу:
https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json
2. Вывести title и page_id
 */
function task4()
{
    $link = file_get_contents("https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json");
    $getArray = json_decode($link, true);
    $searchingString[] = $getArray['query']['pages']['15580374'];
    foreach ($searchingString as $string) {
        echo "pageid - {$string['pageid']}</br>";
        echo "title - {$string['title']}</br>";
    }
    echo '<hr>';
    return;
}