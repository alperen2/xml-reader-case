<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="background-shape"></div>

    <div class="container">
        <? if ($result): ?>
            <form>
                <input type="text" name="author" placeholder="Search by author name">
                <button type="submit">Ara</button>
            </form>

            <table border="1">
                <tr>
                    <th>Auhtor</th>
                    <th>Book</th>
                </tr>
                <?php foreach ($result as $book): ?>
                    <tr>
                        <td><?=$book['author']?></td>
                        <td><?=$book['book']?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        <? endif ?>
    </div>
    
</body>
</html>