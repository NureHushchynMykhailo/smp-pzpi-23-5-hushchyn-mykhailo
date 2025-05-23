<?php

$products = [
    1 => ['name' => 'Йогурт полуничний', 'price' => 15],
    2 => ['name' => 'Паляниця', 'price' => 12],
    3 => ['name' => 'Масло вершкове', 'price' => 42],
    4 => ['name' => 'Ковбаса варена', 'price' => 60],
    5 => ['name' => 'Сік апельсиновий', 'price' => 25],
    6 => ['name' => 'Чай зелений', 'price' => 30],
    7 => ['name' => 'Шоколад молочний', 'price' => 22],
    8 => ['name' => 'Макарони спагеті', 'price' => 18],
    9 => ['name' => 'Цукор', 'price' => 20],
    10 => ['name' => 'Яйця курячі (10 шт)', 'price' => 38],
];


$cart = [];
$user = ['name' => '', 'age' => 0];

function ClearScreen() {
    echo "\n";
}

function PrintMainMenu() {
    echo "################################\n";
    echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
    echo "################################\n";
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
    echo "Введіть команду: ";
}
function PrintProducts($products)
{
    echo "№   НАЗВА                                ЦІНА\n";
    echo "--------------------------------------------------\n";
    foreach ($products as $id => $item)
    {
        printf("%-3d %-35s %5d\n", $id, $item['name'], $item['price']);
    }
    echo "--------------------------------------------------\n";
    echo "0   ПОВЕРНУТИСЯ\n";
}



function PrintCart($cart) 
{
    if (empty($cart)) {
        echo "КОШИК ПОРОЖНІЙ\n";
        return;
    }
    echo "У КОШИКУ:\n";
    echo "НАЗВА                     КІЛЬКІСТЬ\n";
    foreach ($cart as $item) {
        printf("%-25s %d\n", $item['name'], $item['quantity']);
    }
}

function GetInput() 
{
    return trim(fgets(STDIN));
}

while (true) 
{
    PrintMainMenu();
    $command = GetInput();

    if (!in_array($command, ['0', '1', '2', '3']))
    {
        echo "ПОМИЛКА! Введіть правильну команду\n\n";
        continue;
    }

    if ($command == '0') {
        echo "Дякуємо за покупки! До побачення!\n";
        break;
    }

    if ($command == '1') {
        while (true) {
            PrintProducts($products);
            echo "Виберіть товар: ";
            $product_id = GetInput();

            if ($product_id == '0') break;

            if (!array_key_exists($product_id, $products)) 
            {
                echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
                continue;
            }

            $product = $products[$product_id];
            echo "Вибрано: {$product['name']}\n";
            echo "Введіть кількість, штук: ";
            $quantity = GetInput();

            if (!is_numeric($quantity) || $quantity < 0 || $quantity >= 100) 
            {
                echo "ПОМИЛКА! Введіть коректну кількість (0-99)\n";
                continue;
            }

            if ($quantity == 0) {
                unset($cart[$product_id]);
                echo "ВИДАЛЯЮ З КОШИКА\n";
                PrintCart($cart);
                continue;
            }

            $cart[$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];

            PrintCart($cart);
        }
    }

    if ($command == '2') {
        if (empty($cart)) {
            echo "КОШИК ПОРОЖНІЙ. Спершу оберіть товари.\n";
            continue;
        }

        echo "№  НАЗВА                     ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
        $total = 0;
        $index = 1;
        foreach ($cart as $item) {
            $cost = $item['price'] * $item['quantity'];
            printf("%-2d %-25s %-5d %-9d %d\n", $index, $item['name'], $item['price'], $item['quantity'], $cost);
            $total += $cost;
            $index++;
        }
        echo "РАЗОМ ДО CПЛАТИ: $total\n";
    }

    if ($command == '3') {
        echo "Ваше імʼя: ";
        $name = GetInput();
       if (!preg_match('/[A-Za-zА-Яа-яІіЇїЄєҐґ]/u', $name))
        {
    echo "ПОМИЛКА! Імʼя повинно містити хоча б одну літеру\n";
    continue;
}



        echo "Ваш вік: ";
        $age = GetInput();
        if (!is_numeric($age) || $age < 7 || $age > 150) {
            echo "ПОМИЛКА! Вік має бути від 7 до 150 років\n";
            continue;
        }

        $user['name'] = $name;
        $user['age'] = $age;
        echo "Профіль успішно оновлено!\n";
    }

    ClearScreen();
}
?>
